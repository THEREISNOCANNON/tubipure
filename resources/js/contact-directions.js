(function () {
  'use strict';

  const map = document.getElementById('contactDirectionsMap');
  const button = document.getElementById('showContactDirections');
  if (!map || !button) return;

  const company = {
    lat: Number(document.querySelector('meta[name="company-latitude"]').content),
    lon: Number(document.querySelector('meta[name="company-longitude"]').content),
  };
  const tileLayer = document.getElementById('contactDirectionsTiles');
  const routeLayer = document.getElementById('contactDirectionsRoute');
  const markerLayer = document.getElementById('contactDirectionsMarkers');
  const feedback = document.getElementById('contactDirectionsFeedback');
  const summary = document.getElementById('contactDirectionsSummary');
  const stepsList = document.getElementById('contactDirectionsSteps');
  const tiles = new Map();
  const tileUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
  let center = { ...company, zoom: 16 };
  let route = null;

  function worldPoint(lat, lon, zoom) {
    const size = 256 * 2 ** zoom;
    const radians = Math.max(-85.0511, Math.min(85.0511, lat)) * Math.PI / 180;
    return {
      x: ((lon + 180) / 360) * size,
      y: (0.5 - Math.log((1 + Math.sin(radians)) / (1 - Math.sin(radians))) / (4 * Math.PI)) * size,
    };
  }

  function fitRoute(coordinates) {
    const bounds = coordinates.reduce((result, [lon, lat]) => ({
      minLat: Math.min(result.minLat, lat),
      maxLat: Math.max(result.maxLat, lat),
      minLon: Math.min(result.minLon, lon),
      maxLon: Math.max(result.maxLon, lon),
    }), { minLat: Infinity, maxLat: -Infinity, minLon: Infinity, maxLon: -Infinity });
    const width = map.clientWidth - 110;
    const height = map.clientHeight - 90;
    let zoom = 3;
    for (let candidate = 3; candidate <= 18; candidate += 1) {
      const northWest = worldPoint(bounds.maxLat, bounds.minLon, candidate);
      const southEast = worldPoint(bounds.minLat, bounds.maxLon, candidate);
      if (southEast.x - northWest.x <= width && southEast.y - northWest.y <= height) zoom = candidate;
      else break;
    }
    const northWest = worldPoint(bounds.maxLat, bounds.minLon, zoom);
    const southEast = worldPoint(bounds.minLat, bounds.maxLon, zoom);
    const midpoint = {
      x: (northWest.x + southEast.x) / 2,
      y: (northWest.y + southEast.y) / 2,
    };
    const size = 256 * 2 ** zoom;
    center = {
      lat: Math.atan(Math.sinh(Math.PI * (1 - (2 * midpoint.y) / size))) * 180 / Math.PI,
      lon: midpoint.x / size * 360 - 180,
      zoom,
    };
  }

  function render() {
    const rect = map.getBoundingClientRect();
    if (!rect.width || !rect.height) return;
    const world = worldPoint(center.lat, center.lon, center.zoom);
    const left = world.x - rect.width / 2;
    const top = world.y - rect.height / 2;
    const limit = 2 ** center.zoom;
    const retained = new Set();

    for (let y = Math.max(0, Math.floor(top / 256) - 1); y <= Math.min(limit - 1, Math.floor((top + rect.height) / 256) + 1); y += 1) {
      for (let x = Math.floor(left / 256) - 1; x <= Math.floor((left + rect.width) / 256) + 1; x += 1) {
        const wrappedX = ((x % limit) + limit) % limit;
        const key = `${center.zoom}/${x}/${y}`;
        let tile = tiles.get(key);
        if (!tile) {
          tile = document.createElement('img');
          tile.className = 'contact-directions-tile';
          tile.alt = '';
          tile.draggable = false;
          tile.decoding = 'async';
          tile.src = tileUrl.replace('{z}', center.zoom).replace('{x}', wrappedX).replace('{y}', y);
          tiles.set(key, tile);
          tileLayer.append(tile);
        }
        tile.style.left = `${x * 256 - left}px`;
        tile.style.top = `${y * 256 - top}px`;
        retained.add(key);
      }
    }
    for (const [key, tile] of tiles) {
      if (!retained.has(key)) {
        tile.remove();
        tiles.delete(key);
      }
    }

    const end = worldPoint(company.lat, company.lon, center.zoom);
    const endMarker = document.createElement('span');
    endMarker.className = 'contact-directions-marker contact-directions-marker-end';
    endMarker.style.left = `${end.x - left}px`;
    endMarker.style.top = `${end.y - top}px`;
    endMarker.title = 'TubiPure Water Refilling Station';
    endMarker.setAttribute('aria-label', 'TubiPure Water Refilling Station');
    endMarker.innerHTML = '<svg viewBox="0 0 24 32" aria-hidden="true"><path d="M12 31S2 19.3 2 12a10 10 0 1 1 20 0c0 7.3-10 19-10 19Z" fill="currentColor"/><circle cx="12" cy="12" r="4" fill="white"/></svg>';
    const markers = [endMarker];

    if (route) {
      const points = route.geometry.coordinates.map(([lon, lat]) => {
        const point = worldPoint(lat, lon, center.zoom);
        return [point.x - left, point.y - top];
      });
      const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttribute('d', points.map(([x, y], index) => `${index ? 'L' : 'M'} ${x} ${y}`).join(' '));
      routeLayer.setAttribute('viewBox', `0 0 ${rect.width} ${rect.height}`);
      routeLayer.replaceChildren(path);

      const start = worldPoint(route.start.lat, route.start.lon, center.zoom);
      const startMarker = document.createElement('span');
      startMarker.className = 'contact-directions-marker contact-directions-marker-start';
      startMarker.style.left = `${start.x - left}px`;
      startMarker.style.top = `${start.y - top}px`;
      startMarker.title = 'Your location';
      markers.push(startMarker);
    } else {
      routeLayer.replaceChildren();
    }
    markerLayer.replaceChildren(...markers);
  }

  function formatDistance(meters) {
    return meters >= 1000 ? `${(meters / 1000).toFixed(1)} km` : `${Math.round(meters)} m`;
  }

  function formatDuration(seconds) {
    const minutes = Math.max(1, Math.round(seconds / 60));
    if (minutes < 60) return `${minutes} min drive`;
    const hours = Math.floor(minutes / 60);
    const remainder = minutes % 60;
    return `${hours} hr${hours > 1 ? 's' : ''}${remainder ? ` ${remainder} min` : ''} drive`;
  }

  function describeStep(step) {
    const maneuver = step.maneuver || {};
    const type = maneuver.type || 'continue';
    const modifier = maneuver.modifier ? ` ${maneuver.modifier}` : '';
    const road = step.name ? ` onto ${step.name}` : '';
    const instruction = type === 'arrive'
      ? 'Arrive at TubiPure Water Refilling Station'
      : type === 'depart'
        ? `Start${road}`
        : type === 'roundabout' || type === 'rotary'
          ? `Enter the roundabout${road}`
          : `${type[0].toUpperCase()}${type.slice(1)}${modifier}${road}`;
    return `${instruction} · ${formatDistance(step.distance)}`;
  }

  function showRoute(result, start) {
    const selectedRoute = result.routes?.[0];
    if (result.code !== 'Ok' || !selectedRoute) throw new Error('No drivable route was found from your location. Try again somewhere with road access.');
    route = { ...selectedRoute, start };
    fitRoute(route.geometry.coordinates);
    render();
    summary.replaceChildren();
    [formatDistance(route.distance), formatDuration(route.duration), 'Driving directions'].forEach(text => {
      const item = document.createElement('span');
      item.textContent = text;
      summary.append(item);
    });
    summary.hidden = false;
    stepsList.replaceChildren();
    const steps = (route.legs || []).flatMap(leg => leg.steps || []).filter(step => step.distance > 0 || step.maneuver?.type === 'arrive');
    steps.forEach(step => {
      const item = document.createElement('li');
      item.textContent = describeStep(step);
      stepsList.append(item);
    });
    stepsList.hidden = !steps.length;
    feedback.textContent = 'Route from your current location to TubiPure Water Refilling Station.';
  }

  button.addEventListener('click', () => {
    if (!navigator.geolocation) {
      feedback.textContent = 'Your browser does not support location access. Try a current version of Chrome, Edge, Safari, or Firefox.';
      return;
    }
    button.disabled = true;
    feedback.textContent = 'Getting your location…';
    navigator.geolocation.getCurrentPosition(async position => {
      const start = { lat: position.coords.latitude, lon: position.coords.longitude };
      feedback.textContent = 'Finding a route to TubiPure…';
      try {
        const url = `https://router.project-osrm.org/route/v1/driving/${start.lon},${start.lat};${company.lon},${company.lat}?overview=full&geometries=geojson&steps=true`;
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        if (!response.ok) throw new Error('Directions are temporarily unavailable. Please try again shortly.');
        showRoute(await response.json(), start);
      } catch (error) {
        feedback.textContent = error.message || 'Directions could not be loaded. Please try again.';
      } finally {
        button.disabled = false;
      }
    }, error => {
      feedback.textContent = error.code === error.PERMISSION_DENIED
        ? 'Location access is blocked. Allow location access in your browser settings, then try again.'
        : 'Your location could not be determined. Check location access and try again.';
      button.disabled = false;
    }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 60000 });
  });

  render();
  window.addEventListener('resize', render);
  window.addEventListener('hashchange', () => requestAnimationFrame(render));
  new MutationObserver(render).observe(document.getElementById('page-contact'), {
    attributes: true,
    attributeFilter: ['class'],
  });
  new ResizeObserver(render).observe(map);
})();

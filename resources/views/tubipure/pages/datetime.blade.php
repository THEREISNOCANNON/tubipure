<section class="page" id="page-datetime">
  <div class="page-head"><div class="wrap">
    <div>
      <h1>Date &amp; Time</h1>
      <p>Set the days and hours when the station is open and deliveries are available.</p>
    </div>
  </div></div>
  <div class="page-body"><div class="wrap">
    <section class="datetime-settings-page" id="dateTimeSettingsPanel" style="display:none;" aria-label="Weekly operating hours">
      <form id="dateTimeSettingsForm" class="datetime-settings-form">
        @foreach ([['key' => 'station_schedule', 'title' => 'Station Hours', 'description' => 'Set when the water station is open for pickup.', 'from' => 'Opens', 'until' => 'Closes', 'icon' => 'station'], ['key' => 'delivery_schedule', 'title' => 'Delivery Hours', 'description' => 'Set the days and times when delivery is available.', 'from' => 'Available from', 'until' => 'Available until', 'icon' => 'delivery']] as $schedule)
          <section class="card datetime-schedule-card" aria-labelledby="{{ $schedule['key'] }}Title">
            <div class="pricing-card-heading">
              <span class="pricing-card-icon" aria-hidden="true">
                @if ($schedule['icon'] === 'station')
                  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                @else
                  <svg viewBox="0 0 24 24"><path d="M3 6h12v12H3zM15 10h4l3 3v5h-7z"/><circle cx="7" cy="19" r="1.5"/><circle cx="18" cy="19" r="1.5"/></svg>
                @endif
              </span>
              <div><h2 id="{{ $schedule['key'] }}Title">{{ $schedule['title'] }}</h2><p>{{ $schedule['description'] }}</p></div>
            </div>
            <div class="datetime-day-list">
              @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <div class="datetime-day-row" data-schedule-row="{{ $schedule['key'] }}" data-schedule-day="{{ $day }}">
                  <label class="datetime-day-toggle"><input type="checkbox" data-schedule-open="{{ $schedule['key'] }}.{{ $day }}"><span>{{ $day }}</span></label>
                  <div class="datetime-day-hours">
                    <div class="datetime-time-field">
                      <span>{{ $schedule['from'] }}</span>
                      <input type="hidden" id="{{ $schedule['key'] }}{{ $day }}OpenInput" data-schedule-time="{{ $schedule['key'] }}.{{ $day }}.opens">
                      <button class="pricing-time-trigger" type="button" data-settings-time-picker="{{ $schedule['key'] }}{{ $day }}OpenInput" aria-haspopup="dialog" aria-controls="orderTimeDialog"><span id="{{ $schedule['key'] }}{{ $day }}OpenDisplay">06:00 AM</span><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
                    </div>
                    <div class="datetime-time-field">
                      <span>{{ $schedule['until'] }}</span>
                      <input type="hidden" id="{{ $schedule['key'] }}{{ $day }}CloseInput" data-schedule-time="{{ $schedule['key'] }}.{{ $day }}.closes">
                      <button class="pricing-time-trigger" type="button" data-settings-time-picker="{{ $schedule['key'] }}{{ $day }}CloseInput" aria-haspopup="dialog" aria-controls="orderTimeDialog"><span id="{{ $schedule['key'] }}{{ $day }}CloseDisplay">06:00 PM</span><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
                    </div>
                  </div>
                  <span class="datetime-closed-label" hidden>Closed</span>
                </div>
              @endforeach
            </div>
          </section>
        @endforeach
        <div class="datetime-settings-actions"><p id="dateTimeSettingsFeedback" aria-live="polite"></p><button class="btn btn-primary" id="saveDateTimeSettingsBtn" type="submit">Save Hours</button></div>
      </form>
    </section>
  </div></div>
</section>

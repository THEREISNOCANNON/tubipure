<section class="page" id="page-dashboard">
  <div class="page-head"><div class="wrap">
    <div class="dashboard-page-heading">
      <div><h1>Overview</h1><p>A quick snapshot of TubiPure's operations.</p></div>
      <div class="dashboard-date" aria-label="Today's date">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="3" stroke="currentColor" stroke-width="1.7"/><path d="M16 3v4M8 3v4M3 10h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M8 14h3m-3 3h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        <span><small>Today</small><strong id="dashboardDate">—</strong></span>
      </div>
    </div>
  </div></div>
  <div class="page-body"><div class="wrap">
    <section class="dashboard-upcoming-reminder" id="dashboardUpcomingReminder" aria-labelledby="dashboardReminderTitle" hidden>
      <span class="dashboard-reminder-bell" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9ZM10 21h4"/></svg></span>
      <span class="dashboard-reminder-divider" aria-hidden="true"></span>
      <div class="dashboard-reminder-copy">
        <h2 id="dashboardReminderTitle">Upcoming Delivery Reminder</h2>
        <p id="dashboardReminderInstruction"></p>
        <div class="dashboard-reminder-details">
          <span class="dashboard-reminder-schedule"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><span>Scheduled delivery: <strong id="dashboardReminderScheduledTime"></strong></span></span>
          <span class="dashboard-reminder-sent"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h12v11H3zM15 11h4l3 3v4h-7z"/><circle cx="7.5" cy="18" r="2"/><circle cx="18.5" cy="18" r="2"/></svg><span>Reminder sent at <strong id="dashboardReminderSentAt"></strong> (1 hour before).</span></span>
        </div>
      </div>
      <span class="dashboard-reminder-due" id="dashboardReminderDue"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><span></span></span>
      <button class="dashboard-reminder-view" id="dashboardReminderViewOrder" type="button">View Order <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button>
    </section>
    <section class="dashboard-revenue-grid" aria-label="Revenue summary">
      <article class="card dashboard-revenue-card dashboard-revenue-water" aria-labelledby="dashboardWaterTitle">
        <span class="dashboard-revenue-icon" aria-hidden="true"><img src="/images/water-gallon-icon.png" alt=""></span>
        <h2 id="dashboardWaterTitle">Water Sales</h2>
        <strong id="dashboardWaterRevenue">₱0.00</strong>
        <span class="dashboard-revenue-description">From gallon orders</span>
        <svg class="dashboard-revenue-watermark" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 19c4-5 7-6 11-4s6 1 9-3v10H2z"/></svg>
      </article>
      <article class="card dashboard-revenue-card dashboard-revenue-fees" aria-labelledby="dashboardFeesTitle">
        <span class="dashboard-revenue-icon" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M4 12h25v22H4zM29 19h8l7 8v7H29z"/><circle cx="14" cy="36" r="4"/><circle cx="36" cy="36" r="4"/><path d="M8 18h13M8 23h9"/></svg></span>
        <h2 id="dashboardFeesTitle">Delivery Fees</h2>
        <strong id="dashboardShippingCost">₱0.00</strong>
        <span class="dashboard-revenue-description">Collected from deliveries</span>
        <svg class="dashboard-revenue-watermark" viewBox="0 0 48 48" aria-hidden="true"><path d="M4 12h25v22H4zM29 19h8l7 8v7H29z"/><circle cx="14" cy="36" r="4"/><circle cx="36" cy="36" r="4"/></svg>
      </article>
      <article class="card dashboard-revenue-card dashboard-revenue-total" aria-labelledby="dashboardTotalTitle">
        <span class="dashboard-revenue-icon" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M14 13c0-4 4-7 10-7s10 3 10 7M13 14h22l7 9-8 17H14L6 23z"/><path d="M24 18v18m5-13c0-2-2-3-5-3s-5 1-5 3 2 3 5 3 5 1 5 3-2 3-5 3-5-1-5-3"/></svg></span>
        <h2 id="dashboardTotalTitle">Total Revenue</h2>
        <strong id="dashboardOverallTotal">₱0.00</strong>
        <span class="dashboard-revenue-description">Water sales + delivery fees</span>
        <svg class="dashboard-revenue-watermark" viewBox="0 0 48 48" aria-hidden="true"><path d="M5 40h7V26H5zM18 40h7V17h-7zM31 40h7V8h-7zM34 5l8 1-1 8"/></svg>
      </article>
    </section>
    <div class="dashboard-content-grid">
      <div class="card chart-wrap dashboard-volume-card">
        <div class="dashboard-volume-heading">
          <div class="dashboard-volume-copy">
            <h2>Delivery Volume</h2>
            <p>Track the number of gallons delivered over time.</p>
          </div>
          <div class="dashboard-volume-controls">
            <div class="dashboard-chart-type" role="group" aria-label="Delivery volume chart type">
              <button class="is-active" type="button" data-volume-chart-type="line" aria-pressed="true">Line Chart</button>
              <button type="button" data-volume-chart-type="area" aria-pressed="false">Area Chart</button>
              <button type="button" data-volume-chart-type="bar" aria-pressed="false">Bar Graph</button>
            </div>
            <label><span class="sr-only">Delivery volume time range</span><select id="deliveryVolumeRange" aria-label="Delivery volume time range"><option value="day">Last 7 Days</option><option value="week">By Week</option><option value="month">By Month</option><option value="year">By Year</option></select></label>
            <label><span class="sr-only">Water type</span><select id="deliveryVolumeWaterType" aria-label="Filter by water type"><option value="all">All Water</option><option value="alkaline">Alkaline</option><option value="purified">Purified</option></select></label>
          </div>
        </div>
        <div class="dashboard-volume-stats" aria-live="polite">
          <div class="dashboard-volume-stat dashboard-volume-stat-total"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h12v12H3zM15 10h4l3 3v5h-7z"/><circle cx="7" cy="19" r="1.5"/><circle cx="18" cy="19" r="1.5"/></svg><span><strong id="volumeTotalDelivered">0 gal</strong><small>Total Delivered</small></span></div>
          <div class="dashboard-volume-stat dashboard-volume-stat-average"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 20V11h4v9M10 20V7h4v13M17 20V3h4v17"/></svg><span><strong id="volumeAveragePerDay">0 gal</strong><small>Average per day</small></span></div>
          <div class="dashboard-volume-stat dashboard-volume-stat-high"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 21h8M12 17v4M5 4h14v4a7 7 0 0 1-14 0V4ZM5 6H3v2a4 4 0 0 0 4 4m12-6h2v2a4 4 0 0 1-4 4"/></svg><span><strong id="volumeHighestDay">0 gal</strong><small>Highest in a day</small></span></div>
        </div>
        <canvas id="volChart" width="640" height="230" role="img" aria-label="Gallons delivered over the last seven days"></canvas>
        <div class="dashboard-volume-legend" id="dashboardVolumeLegend" aria-label="Chart legend"></div>
      </div>
      <div class="card dashboard-status-card">
        <div class="section-title"><h2>Order status summary</h2></div>
        <div class="dashboard-status-content">
          <div class="dashboard-donut" id="statusDonut" role="img" aria-label="Order status breakdown"><div><strong id="statusTotal">0</strong><span>Total orders</span></div></div>
          <div class="dashboard-status-list" id="statusSummary"></div>
        </div>
      </div>
      <div class="kpi-grid dashboard-kpi-grid" id="kpiGrid"></div>
      <div class="card dashboard-table-card">
        <div class="section-title"><h2>Today's deliveries</h2><button class="dashboard-view-all" type="button" data-route="scheduler">View all →</button></div>
        <div class="table-wrap dashboard-table-wrap"><table class="dashboard-table"><thead><tr><th>#</th><th>Customer</th><th>Gallons</th><th>Time</th><th>Location</th><th>Status</th></tr></thead><tbody id="todayDeliveriesBody"></tbody></table></div>
        <div class="dashboard-empty" id="todayDeliveriesEmpty" hidden>No deliveries scheduled today.</div>
      </div>
      <div class="dashboard-side-stack">
        <div class="card dashboard-recent-card">
          <div class="section-title"><h2>Recent orders</h2><button class="dashboard-view-all" type="button" data-route="scheduler">View all →</button></div>
          <div class="table-wrap dashboard-table-wrap"><table class="dashboard-table dashboard-compact-table"><thead><tr><th>#</th><th>Customer</th><th>Gallons</th><th>Total</th><th>Status</th><th>Date</th></tr></thead><tbody id="recentOrdersBody"></tbody></table></div>
          <div class="dashboard-empty" id="recentOrdersEmpty" hidden>No orders yet.</div>
        </div>
        <div class="card dashboard-zones-card">
          <div class="section-title"><h2>Delivery zones / pricing</h2><button class="dashboard-view-all" type="button" data-route="kmr">View all →</button></div>
          <div class="table-wrap dashboard-table-wrap"><table class="dashboard-table dashboard-compact-table"><thead><tr><th>Zone</th><th>Distance</th><th>Delivery fee</th><th>Coverage</th></tr></thead><tbody id="dashboardZonesBody"></tbody></table></div>
        </div>
      </div>
    </div>
  </div></div>
</section>

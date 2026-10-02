<section class="page" id="page-users">
  <div class="page-head"><div class="wrap">
    <div>
      <h1>Users</h1>
      <p>Manage registered app accounts.</p>
    </div>
  </div></div>
  <div class="page-body"><div class="wrap">
    <div class="users-kpi-grid" aria-label="User account summary">
      <article class="users-kpi users-kpi-blue">
        <span class="users-kpi-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M16 21v-1.8a3.2 3.2 0 0 0-3.2-3.2H6.2A3.2 3.2 0 0 0 3 19.2V21M9.5 12a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM17 11a3 3 0 1 0 0-6M17 16h1a3 3 0 0 1 3 3v2"/></svg></span>
        <span class="users-kpi-value" id="usersTotalCount">0</span><span class="users-kpi-label">Total users</span><span class="users-kpi-share" id="usersTotalShare">0%</span>
        <svg class="users-kpi-watermark" viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-1.8a3.2 3.2 0 0 0-3.2-3.2H6.2A3.2 3.2 0 0 0 3 19.2V21M9.5 12a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM17 11a3 3 0 1 0 0-6M17 16h1a3 3 0 0 1 3 3v2"/></svg>
      </article>
      <article class="users-kpi users-kpi-green">
        <span class="users-kpi-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2Z"/></svg></span>
        <span class="users-kpi-value" id="usersActiveCount">0</span><span class="users-kpi-label">Active users</span><span class="users-kpi-share" id="usersActiveShare">0%</span>
        <svg class="users-kpi-watermark" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2Z"/></svg>
      </article>
      <article class="users-kpi users-kpi-purple">
        <span class="users-kpi-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a7 7 0 0 1 14 0v2ZM19 8v6M16 11h6"/></svg></span>
        <span class="users-kpi-value" id="usersNewMonthCount">0</span><span class="users-kpi-label">New this month</span><span class="users-kpi-share" id="usersNewMonthShare">0%</span>
        <svg class="users-kpi-watermark" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20h3V12H4zM10.5 20h3V7h-3zM17 20h3V3h-3z"/></svg>
      </article>
      <article class="users-kpi users-kpi-red">
        <span class="users-kpi-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a7 7 0 0 1 14 0v2ZM18 9l5 5M23 9l-5 5"/></svg></span>
        <span class="users-kpi-value" id="usersDisabledCount">0</span><span class="users-kpi-label">Disabled users</span><span class="users-kpi-share" id="usersDisabledShare">0%</span>
        <svg class="users-kpi-watermark" viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-1.8a3.2 3.2 0 0 0-3.2-3.2H6.2A3.2 3.2 0 0 0 3 19.2V21M9.5 12a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM17 9l5 5M22 9l-5 5"/></svg>
      </article>
    </div>
    <div class="card users-card">
      <div class="users-toolbar">
        <label class="search-box users-search">
          <svg class="si" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/><path d="m21 21-4.3-4.3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
          <input type="search" id="usersSearch" placeholder="Search by name, email, or contact number..." aria-label="Search users">
        </label>
        <select class="users-select" id="usersStatusFilter" aria-label="Filter users by status">
          <option value="all">All statuses</option>
          <option value="Active">Active</option>
          <option value="Pending">Pending</option>
          <option value="Disabled">Disabled</option>
        </select>
        <select class="users-select" id="usersSort" aria-label="Sort users">
          <option value="newest">Sort: Newest</option>
          <option value="oldest">Sort: Oldest</option>
          <option value="name">Sort: Name A–Z</option>
        </select>
      </div>
      <div class="table-wrap users-table-wrap">
        <table class="users-table">
          <thead><tr><th>User</th><th>Contact</th><th>Joined</th><th>Status</th></tr></thead>
          <tbody id="usersTableBody"></tbody>
        </table>
      </div>
      <div class="empty-state" id="usersEmpty" hidden>No registered users match your search.</div>
      <p class="users-feedback" id="usersFeedback" role="status" hidden></p>
      <div class="users-table-footer"><span id="usersPageSummary">Showing 0 users</span></div>
    </div>
  </div></div>
</section>

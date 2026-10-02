<section class="page" id="page-customers">
  <div class="page-head"><div class="wrap">
    <div><h1>Customer Records</h1><p>View and manage TubiPure customer information and order history.</p></div>
  </div></div>
  <div class="page-body"><div class="wrap">
    <div class="kpi-grid customer-kpi-grid" id="customerKpiGrid"></div>
    <div class="customer-records-layout is-detail-closed">
      <div class="customer-records-main">
        <div class="card customer-records-toolbar-card">
          <div class="customer-records-toolbar">
            <label class="search-box customer-records-search">
              <svg class="si" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
              <input type="search" id="custSearch" placeholder="Search by name, address, or contact number..." aria-label="Search customer records">
            </label>
            <select class="customer-sort-select" id="custSort" aria-label="Sort customers">
              <option value="name">Sort: Name A–Z</option>
              <option value="orders">Sort: Most orders</option>
              <option value="last-order">Sort: Latest order</option>
            </select>
            <button class="customer-filter-toggle" id="customerFilterToggle" type="button" aria-label="Customer filters" title="Customer filters">
              <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6h16M7 12h10m-7 6h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="8" cy="6" r="2" fill="var(--theme-surface)" stroke="currentColor" stroke-width="1.6"/><circle cx="15" cy="12" r="2" fill="var(--theme-surface)" stroke="currentColor" stroke-width="1.6"/><circle cx="10" cy="18" r="2" fill="var(--theme-surface)" stroke="currentColor" stroke-width="1.6"/></svg>
            </button>
          </div>
          <div class="customer-filter-pills" role="group" aria-label="Filter customers">
            <button class="customer-filter-pill active" type="button" data-customer-filter="all">All customers</button>
            <button class="customer-filter-pill" type="button" data-customer-filter="active">Active</button>
            <button class="customer-filter-pill" type="button" data-customer-filter="pending">With pending orders</button>
            <button class="customer-filter-pill" type="button" data-customer-filter="inactive">No recent orders</button>
          </div>
        </div>
        <div class="card customer-records-table-card">
          <div class="table-wrap customer-records-table-wrap">
            <table class="customer-records-table">
              <thead><tr><th>Customer</th><th>Address</th><th>Contact</th><th>Total orders</th><th>Last order</th><th>Status</th><th>Actions</th></tr></thead>
              <tbody id="custTableBody"></tbody>
            </table>
          </div>
          <div class="empty-state" id="custEmpty" hidden>
            <svg class="drop" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 2C12 2 5 11 5 15.5C5 19.09 8.13 22 12 22C15.87 22 19 19.09 19 15.5C19 11 12 2 12 2Z" fill="currentColor"/></svg>
            No customers match this search or filter.
          </div>
          <div class="customer-table-footer"><span id="customerPageSummary">Showing 0 customers</span><nav class="customer-pagination" id="customerPagination" aria-label="Customer pages"></nav></div>
        </div>
      </div>
      <aside class="card customer-detail-panel" id="customerDetailPanel" aria-label="Customer details" hidden>
        <button class="customer-detail-close" id="customerDetailClose" type="button" aria-label="Close customer details">×</button>
        <div id="customerDetailContent"></div>
      </aside>
    </div>
  </div></div>
</section>

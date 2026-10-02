<section class="page" id="page-scheduler">
  <div class="page-head orders-page-head"><div class="wrap">
    <div class="orders-page-title">
      <span class="orders-page-title-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 2.8 8.2 4.7v9L12 21.2l-8.2-4.7v-9L12 2.8Z"/><path d="m3.8 7.5 8.2 4.8 8.2-4.8M12 12.3v8.9M8 5.1l8.2 4.8"/></svg></span>
      <div><h1>Orders</h1><p>Manage customer orders and track their delivery status.</p></div>
    </div>
    <button class="btn btn-primary orders-add-order-button" id="addOrderButton" type="button">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
      Add Order
    </button>
  </div></div>
  <div class="page-body orders-page-body"><div class="wrap">
    <div class="orders-summary-grid" aria-label="Order summary">
      <button class="orders-summary-card orders-summary-total is-active" type="button" data-orders-summary-filter="Pending" aria-pressed="true">
        <span class="orders-summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="5" y="4.5" width="14" height="17" rx="2"/><path d="M9 3h6v4H9zM9 12h6M9 16h6"/></svg></span>
        <span class="orders-summary-copy"><span>Pending Orders</span><strong id="ordersTotalCount">0</strong></span><span class="orders-summary-arrow" aria-hidden="true">›</span>
        <span class="orders-summary-alert" aria-hidden="true" hidden><svg viewBox="0 0 24 24" fill="none"><path d="M12 5.5v8" stroke="currentColor" stroke-width="2.8" stroke-linecap="round"/><circle cx="12" cy="17.5" r="1.5" fill="currentColor"/></svg></span>
      </button>
      <button class="orders-summary-card orders-summary-todeliver" type="button" data-orders-summary-filter="to-deliver" aria-pressed="false">
        <span class="orders-summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 7h12v11H3zM15 11h4l3 3v4h-7z"/><circle cx="7.5" cy="18" r="2"/><circle cx="18.5" cy="18" r="2"/></svg></span>
        <span class="orders-summary-copy"><span>To Deliver</span><strong id="ordersToDeliverCount">0</strong></span><span class="orders-summary-arrow" aria-hidden="true">›</span>
        <span class="orders-summary-alert" aria-hidden="true" hidden><svg viewBox="0 0 24 24" fill="none"><path d="M12 5.5v8" stroke="currentColor" stroke-width="2.8" stroke-linecap="round"/><circle cx="12" cy="17.5" r="1.5" fill="currentColor"/></svg></span>
      </button>
      <button class="orders-summary-card orders-summary-out-for-delivery" type="button" data-orders-summary-filter="Out for Delivery" aria-pressed="false">
        <span class="orders-summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 7h12v11H3zM15 11h4l3 3v4h-7z"/><circle cx="7.5" cy="18" r="2"/><circle cx="18.5" cy="18" r="2"/></svg></span>
        <span class="orders-summary-copy"><span>Out for Delivery</span><strong id="ordersOutForDeliveryCount">0</strong></span><span class="orders-summary-arrow" aria-hidden="true">›</span>
        <span class="orders-summary-alert" aria-hidden="true" hidden><svg viewBox="0 0 24 24" fill="none"><path d="M12 5.5v8" stroke="currentColor" stroke-width="2.8" stroke-linecap="round"/><circle cx="12" cy="17.5" r="1.5" fill="currentColor"/></svg></span>
      </button>
      <button class="orders-summary-card orders-summary-delivered" type="button" data-orders-summary-filter="Delivered" aria-pressed="false">
        <span class="orders-summary-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m4 12 5 5L20 6"/></svg></span>
        <span class="orders-summary-copy"><span>Delivered</span><strong id="ordersDeliveredCount">0</strong></span><span class="orders-summary-arrow" aria-hidden="true">›</span>
      </button>
    </div>

    <div class="orders-toolbar">
      <label class="orders-status-filter" for="delStatusFilter"><span class="sr-only">Filter orders by status</span>
        <select class="filter" id="delStatusFilter">
          <option value="Pending">Pending Orders</option>
          <option value="to-deliver">To deliver</option>
          <option value="Out for Delivery">Out for Delivery</option>
          <option value="Delivered">Delivered</option>
          <option value="Rejected">Rejected</option>
        </select>
      </label>
      <label class="orders-search" for="delOrderSearch"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5"/></svg><span class="sr-only">Search orders</span><input id="delOrderSearch" type="search" placeholder="Search by name, order #, or address…" autocomplete="off"></label>
      <div class="orders-date-range" aria-label="Filter by order date range">
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="16" rx="2"/><path d="M16 3v4M8 3v4M3.5 10h17M8 14h3"/></svg>
        <label><span class="sr-only">From date</span><input type="date" id="delDateFrom" aria-label="Orders from date"></label>
        <span aria-hidden="true">–</span>
        <label><span class="sr-only">To date</span><input type="date" id="delDateTo" aria-label="Orders to date"></label>
      </div>
    </div>

    <div class="delivery-reminder-alert" id="deliveryReminderAlert" role="alert" aria-live="polite" hidden></div>
    <div class="orders-queue-status" id="ordersQueueStatus" role="status" aria-live="polite"></div>
    <div class="delivery-list orders-list" id="deliveryList"></div>
    <div class="empty-state orders-empty" id="delEmpty" style="display:none;">No orders match these filters.</div>
    <div class="orders-list-footer"><span id="ordersPageSummary" aria-live="polite">Showing 0 orders</span><nav class="orders-pagination" id="ordersPagination" aria-label="Order pages"></nav></div>
  </div></div>
</section>

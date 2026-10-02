<section class="page" id="page-order-history">
  <div class="page-head orders-page-head"><div class="wrap">
    <div class="orders-page-title">
      <span class="orders-page-title-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 5.5h16v15H4z"/><path d="M8 3.5v4M16 3.5v4M4 10h16M8 14h3M8 17h6"/></svg></span>
      <div><h1>Order History</h1><p>Review completed and rejected customer orders.</p></div>
    </div>
  </div></div>
  <div class="page-body orders-page-body"><div class="wrap">
    <div class="order-history-stats" aria-label="Order history summary">
      <article class="order-history-stat"><span>Total history</span><strong id="orderHistoryTotal">0</strong></article>
      <article class="order-history-stat order-history-stat-delivered"><span>Delivered</span><strong id="orderHistoryDelivered">0</strong></article>
      <article class="order-history-stat order-history-stat-rejected"><span>Rejected</span><strong id="orderHistoryRejected">0</strong></article>
    </div>
    <div class="order-history-toolbar">
      <label class="order-history-status-filter" for="orderHistoryStatusFilter"><span>Status</span>
        <select id="orderHistoryStatusFilter"><option value="all">All history</option><option value="Delivered">Delivered</option><option value="Cancelled">Rejected</option></select>
      </label>
      <label class="order-history-search" for="orderHistorySearch"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.5"/><path d="m16 16 5 5"/></svg><input id="orderHistorySearch" type="search" placeholder="Search order, customer, or address" autocomplete="off"></label>
    </div>
    <div class="order-history-list" id="orderHistoryList" aria-live="polite"></div>
    <p class="order-history-count" id="orderHistoryCount" aria-live="polite">Showing 0 historical orders</p>
    <div class="order-history-empty" id="orderHistoryEmpty" hidden>No historical orders match your search.</div>
  </div></div>
</section>

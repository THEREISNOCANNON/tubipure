<section class="page" id="page-myaccount">
  <div class="page-head"><div class="wrap">
    <div>
      <h1 id="custViewTitle">My TubiPure</h1>
      <p id="custViewSub">Check your orders, request a refill, and track your delivery.</p>
    </div>
  </div></div>
  <div class="page-body"><div class="wrap">

    <div class="card cust-login" id="custLoginCard">
      <div class="ic-wrap">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M12 2C12 2 5 11 5 15.5C5 19.09 8.13 22 12 22C15.87 22 19 19.09 19 15.5C19 11 12 2 12 2Z" fill="currentColor"/></svg>
      </div>
      <h2 id="authFormTitle" style="font-size:18px; margin-bottom:6px;">Log in to your account</h2>
      <p class="helper-text" id="authFormDescription" style="margin-bottom:18px;">Enter your email and password to continue.</p>
      <div class="form-row auth-signup-field" style="display:none; text-align:left;">
        <label for="signupName">Full name</label>
        <input id="signupName" type="text" autocomplete="name" maxlength="255" placeholder="Your full name">
      </div>
      <div class="form-row auth-signup-field" style="display:none; text-align:left;">
        <label for="signupAddress">Delivery address</label>
        <input id="signupAddress" type="text" autocomplete="street-address" maxlength="255" placeholder="Purok / street, barangay">
      </div>
      <div class="form-row auth-signup-field" style="display:none; text-align:left;">
        <label for="signupContact">Contact number</label>
        <input id="signupContact" type="tel" autocomplete="tel" maxlength="11" placeholder="09XXXXXXXXX">
      </div>
      <div class="form-row auth-email-field" style="text-align:left;">
        <label for="authEmail">Email address</label>
        <input id="authEmail" type="email" autocomplete="email" placeholder="you@example.com" maxlength="255">
      </div>
      <div class="form-row auth-password-field" style="text-align:left;">
        <label for="authPassword">Password</label>
        <input id="authPassword" type="password" autocomplete="current-password" placeholder="Enter your password" minlength="10">
      </div>
      <div class="form-row auth-signup-field" style="display:none; text-align:left;">
        <label for="signupPasswordConfirmation">Confirm password</label>
        <input id="signupPasswordConfirmation" type="password" autocomplete="new-password" minlength="10" placeholder="Confirm your password">
      </div>
      <div class="form-row auth-reset-field" style="display:none; text-align:left;">
        <label for="resetEmail">Email address</label>
        <input id="resetEmail" type="email" autocomplete="email" placeholder="you@example.com" maxlength="255">
      </div>
      <div class="form-row auth-reset-field" style="display:none; text-align:left;">
        <label for="resetPassword">New password</label>
        <input id="resetPassword" type="password" autocomplete="new-password" minlength="10" placeholder="At least 10 characters">
      </div>
      <div class="form-row auth-reset-field" style="display:none; text-align:left;">
        <label for="resetPasswordConfirmation">Confirm new password</label>
        <input id="resetPasswordConfirmation" type="password" autocomplete="new-password" minlength="10" placeholder="Enter it again">
      </div>
      <button class="btn btn-primary" id="authSubmitBtn" style="width:100%; justify-content:center; margin-top:4px;">Log in</button>
      <button class="switch-link" id="authForgotLink" style="display:block; margin:12px auto 0;">Forgot your password?</button>
      <a class="switch-link" id="authSignupPageLink" href="{{ route('signup') }}" style="display:block; margin:12px auto 0;">New to TubiPure? Sign up</a>
      <button class="switch-link" id="authReturnLogin" style="display:none; margin:12px auto 0;">Back to log in</button>
      <p class="helper-text" id="authFeedback" role="status" aria-live="polite"></p>
    </div>

    <!-- signed-in view -->
    <div id="custSignedIn" style="display:none;">
      <div class="dash-grid customer-account-grid" style="margin-top:20px;">
        <div>
          <div class="customer-orders-page" id="myOrdersCard">
            <div class="customer-orders-summary" aria-label="Order totals">
              <article class="customer-orders-stat customer-orders-stat-total"><span class="customer-orders-stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="14" rx="2"/><path d="M8 7V5a4 4 0 0 1 8 0v2"/></svg></span><span><b id="cvTotalOrders">0</b><strong>Total Orders</strong><small>All your orders</small></span></article>
              <article class="customer-orders-stat customer-orders-stat-active"><span class="customer-orders-stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><span><b id="cvActiveOrders">0</b><strong>Active Orders</strong><small>Pending, confirmed or in progress</small></span></article>
              <article class="customer-orders-stat customer-orders-stat-delivered"><span class="customer-orders-stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M2.5 6.5h12v11h-12zM14.5 10h4l3 3v4h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg></span><span><b id="cvDeliveredOrders">0</b><strong>Delivered Orders</strong><small>Successfully delivered</small></span></article>
            </div>
            <div class="customer-orders-toolbar">
              <div class="customer-orders-filters" id="cvHistoryFilters" role="group" aria-label="Filter orders">
                <button class="customer-order-filter is-active" type="button" data-customer-order-filter="all">All Orders</button>
                <button class="customer-order-filter" type="button" data-customer-order-filter="Pending">Pending</button>
                <button class="customer-order-filter" type="button" data-customer-order-filter="Confirmed">Approved</button>
                <button class="customer-order-filter" type="button" data-customer-order-filter="Out for Delivery">In Progress</button>
                <button class="customer-order-filter" type="button" data-customer-order-filter="Delivered">Delivered</button>
                <button class="customer-order-filter" type="button" data-customer-order-filter="Cancelled">Cancelled</button>
              </div>
              <div class="customer-orders-date-controls">
                <label class="customer-orders-date-filter" for="cvHistoryDate"><span>Ordered date</span><input id="cvHistoryDate" type="date" aria-label="Filter orders by ordered date"></label>
                <button class="customer-orders-date-clear" id="cvHistoryDateClear" type="button" hidden>Clear</button>
              </div>
              <label class="customer-orders-sort" for="cvHistorySort">Sort by
                <select id="cvHistorySort" aria-label="Sort orders"><option value="newest">Newest First</option><option value="oldest">Oldest First</option></select>
              </label>
            </div>
            <div id="cvHistory"></div>
            <p class="customer-orders-count" id="cvHistoryCount" aria-live="polite"></p>
          </div>
        </div>
      </div>
    </div>

  </div></div>
  <dialog class="cancel-order-dialog" id="cancelOrderDialog" aria-labelledby="cancelOrderTitle" aria-describedby="cancelOrderDescription">
    <div class="cancel-order-dialog-card">
      <button class="cancel-order-dialog-close" id="closeCancelOrderDialog" type="button" aria-label="Close confirmation">&times;</button>
      <span class="cancel-order-dialog-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 2.8 19a1.4 1.4 0 0 0 1.2 2.1h16a1.4 1.4 0 0 0 1.2-2.1L12 3Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 9v4.5m0 3h.01" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
      <p class="cancel-order-dialog-eyebrow">Order cancellation</p>
      <h2 id="cancelOrderTitle">Cancel this order?</h2>
      <p id="cancelOrderDescription">Your order is awaiting admin approval. Once cancelled, it can’t be restored.</p>
      <p class="cancel-order-dialog-number">Order <b id="cancelOrderNumber"></b></p>
      <p class="cancel-order-dialog-feedback" id="cancelOrderDialogFeedback" role="status" aria-live="polite"></p>
      <div class="cancel-order-dialog-actions">
        <button class="btn btn-ghost" id="keepCustomerOrder" type="button" autofocus>Keep my order</button>
        <button class="btn" id="confirmCancelCustomerOrder" type="button">Yes, cancel order</button>
      </div>
    </div>
  </dialog>
</section>

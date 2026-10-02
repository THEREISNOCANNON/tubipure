<nav class="nav">
  <div class="nav-inner">
    <a class="brand" href="/#home" aria-label="TubiPure home">
      <span class="mark" aria-hidden="true">
        <img src="/images/tubipure-logo.png" alt="">
      </span>
      <span class="brand-text">
        <span class="name"><span class="tubi">Tubi</span><span class="pure">Pure</span></span>
        <span class="tagline">Clean Water, Healthier You</span>
      </span>
    </a>
    <div class="navlinks" id="navlinks">
      <button class="mobile-account-link mobile-user-nav-link" id="navMobileProfileBtn" data-route="profile" type="button" style="{{ auth()->check() ? '' : 'display: none;' }}">Profile</button>
      <button data-route="home" class="active">Home</button>
      <button id="navMyOrderBtn" data-customer-order-action style="{{ auth()->user()?->role === 'staff' ? 'display: none;' : '' }}">My Order</button>
      <div class="mobile-account-links" id="mobileAccountLinks" aria-label="Account settings" style="{{ auth()->check() ? '' : 'display: none;' }}">
        <button class="mobile-account-link" id="navMobileAddressBtn" data-route="address" type="button">My Address</button>
      </div>
      <button data-route="contact">Contact</button>
      <button data-route="about">About Us</button>
      <button class="mobile-account-link mobile-user-nav-link mobile-settings-link" id="navMobileSettingsBtn" type="button" aria-expanded="false" aria-controls="mobileSettingsSubmenu" style="{{ auth()->check() ? '' : 'display: none;' }}">Settings</button>
      <div class="mobile-settings-submenu" id="mobileSettingsSubmenu" hidden>
        <button class="mobile-account-link" type="button" data-route="profile">Personal Information</button>
        <button class="mobile-account-link" type="button" data-route="change-password">Change Password</button>
      </div>
      <button class="mobile-account-link mobile-user-nav-link" id="navMobileLogoutBtn" type="button" style="{{ auth()->check() ? '' : 'display: none;' }}">Log Out</button>
      <div class="mobile-auth-links" aria-label="Account links">
        <a class="mobile-auth-link" href="{{ route('login') }}">Login</a>
        <a class="mobile-auth-link" href="{{ route('signup') }}">Sign up</a>
      </div>
    </div>
    <div class="nav-right">
      <button class="nav-dashboard" id="navDashboardBtn" data-route="dashboard" data-staff-route type="button" aria-label="Dashboard" style="display:none;">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.8"/><rect x="13" y="3" width="8" height="5" rx="2" stroke="currentColor" stroke-width="1.8"/><rect x="13" y="10" width="8" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/><rect x="3" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.8"/></svg>
        <span>Dashboard</span>
        <strong class="dashboard-notification-badge" id="dashboardNotificationBadge" style="display:none;" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M12 5.5v8" stroke="currentColor" stroke-width="2.8" stroke-linecap="round"/><circle cx="12" cy="17.5" r="1.5" fill="currentColor"/></svg></strong>
      </button>
      <button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch to dark mode" title="Switch to dark mode" aria-pressed="false">
        <svg class="theme-icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.4 15.4A8.5 8.5 0 018.6 3.6 8.5 8.5 0 1020.4 15.4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <svg class="theme-icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
      </button>
      <button class="bell" id="bellBtn" aria-label="Notifications" aria-expanded="false" style="{{ auth()->check() ? '' : 'display: none;' }}">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        <span class="dot" id="bellDot" style="display:none;" aria-hidden="true"></span>
      </button>
      <div class="notif-panel" id="notifPanel">
        <div class="notif-heading">
          <h4 id="notifTitle">Delivery reminders</h4>
          <button type="button" class="notif-mark-read" id="markNotificationsRead">Mark all as read</button>
        </div>
        <div id="notifList"></div>
      </div>
      <button class="nav-cta" id="navCtaBtn" data-customer-order-action aria-label="Order now" style="{{ auth()->user()?->role === 'staff' ? 'display: none;' : '' }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="9" cy="21" r="1.4" fill="currentColor"/><circle cx="18" cy="21" r="1.4" fill="currentColor"/><path d="M2.5 3h2l2.3 12.4a2 2 0 002 1.6h8.4a2 2 0 002-1.6L21 7H6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Order Now
      </button>
      <div class="nav-profile-wrap" id="navProfileMenuWrap" style="{{ auth()->check() ? '' : 'display: none;' }}">
        <button class="nav-profile" id="navProfileBtn" type="button" aria-label="Open account menu" title="Account menu" aria-haspopup="menu" aria-expanded="false" aria-controls="navProfileMenu">
          <span class="nav-profile-avatar" id="navProfileAvatar" aria-hidden="true"></span>
        </button>
        <div class="nav-profile-menu" id="navProfileMenu" role="menu" aria-labelledby="navProfileBtn" hidden>
          <div class="nav-profile-menu-header">
            <span id="navProfileMenuName"></span>
            <small id="navProfileMenuRole"></small>
          </div>
          <button type="button" id="navProfileSettingsBtn" role="menuitem" aria-haspopup="true" aria-expanded="false" aria-controls="navSettingsSubmenu">
            <svg viewBox="0 0 24 24" aria-hidden="true"><mask id="customerSettingsGearHole"><rect width="24" height="24" fill="#fff"/><circle cx="12" cy="12" r="3.5" fill="#000"/></mask><g fill="currentColor" mask="url(#customerSettingsGearHole)"><circle cx="12" cy="12" r="8.2"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5" transform="rotate(45 12 12)"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5" transform="rotate(90 12 12)"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5" transform="rotate(135 12 12)"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5" transform="rotate(180 12 12)"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5" transform="rotate(225 12 12)"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5" transform="rotate(270 12 12)"/><rect x="9.8" y=".5" width="4.4" height="8" rx="1.5" transform="rotate(315 12 12)"/></g></svg>
            <span>Settings</span>
            <svg class="nav-settings-chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
          </button>
          <div class="nav-settings-submenu" id="navSettingsSubmenu" role="group" aria-label="Settings pages" hidden>
            <button type="button" data-route="profile" role="menuitem">Personal Information</button>
            <button type="button" data-route="change-password" role="menuitem">Change Password</button>
          </div>
          <button type="button" id="navProfileAddressBtn" data-route="address" role="menuitem">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0Z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.8"/></svg>
            <span>My Address</span>
          </button>
          <button type="button" id="navProfileLogoutBtn" class="nav-profile-logout" role="menuitem">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3m9-9h5a3 3 0 013 3v12a3 3 0 01-3 3h-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Log Out</span>
          </button>
        </div>
      </div>
      <div class="nav-auth">
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('signup') }}">Sign up</a>
      </div>
      <button class="navToggle" id="navToggle" aria-label="Menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>
  </div>
</nav>

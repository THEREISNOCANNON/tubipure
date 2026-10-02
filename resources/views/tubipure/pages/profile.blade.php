<section class="page" id="page-profile">
  <div class="page-head"><div class="wrap">
    <div class="dashboard-page-heading">
      <button class="dashboard-back-button staff-only" data-route="dashboard" type="button" aria-label="Back to admin dashboard" style="display:none;">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5m7 7-7-7 7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span>Back to Dashboard</span>
      </button>
      <h1>Personal Information</h1>
      <p>Review and update the personal details associated with your TubiPure account.</p>
    </div>
  </div></div>
  <div class="page-body"><div class="wrap">
    <article class="card profile-card" aria-labelledby="profileName">
      <div class="profile-heading">
        <span class="avatar profile-avatar" id="profileAvatar" aria-hidden="true"></span>
        <div class="profile-heading-copy">
          <h2 id="profileName"></h2>
          <span class="profile-role" id="profileRole"></span>
        </div>
        <button class="btn btn-outline profile-edit-trigger" id="editProfileButton" type="button">Edit profile</button>
      </div>
      <dl class="profile-details" id="profileDetails">
        <div class="profile-detail">
          <dt>Email address</dt>
          <dd id="profileEmail"></dd>
        </div>
        <div class="profile-detail" id="profileContactRow" hidden>
          <dt>Contact number</dt>
          <dd id="profileContact"></dd>
        </div>
        <div class="profile-detail profile-detail-wide" id="profileAddressRow" hidden>
          <dt>My Address</dt>
          <dd id="profileAddress"></dd>
          <a class="profile-address-manage" href="#address" data-route="address">Manage saved addresses</a>
        </div>
      </dl>
      <form class="profile-edit-form" id="profileEditForm" hidden>
        <div class="profile-edit-fields">
          <div class="form-row" id="profileEditNameRow">
            <label for="profileEditName">Full name</label>
            <input id="profileEditName" name="name" type="text" autocomplete="name" maxlength="255" required>
            <small class="err" data-error-for="name"></small>
          </div>
          <div class="form-row" id="profileEditEmailRow">
            <label for="profileEditEmail">Email address</label>
            <input id="profileEditEmail" name="email" type="email" autocomplete="email" maxlength="255" required>
            <small class="err" data-error-for="email"></small>
          </div>
          <div class="form-row" id="profileEditContactField" hidden>
            <label for="profileEditContact">Contact number</label>
            <input id="profileEditContact" name="contact" type="tel" autocomplete="tel" inputmode="numeric" pattern="0[0-9]{10}" maxlength="11" placeholder="09XXXXXXXXX">
            <small class="err" data-error-for="contact"></small>
          </div>
        </div>
        <p class="profile-edit-feedback" id="profileEditFeedback" role="status" aria-live="polite" hidden></p>
        <div class="profile-edit-actions">
          <button class="btn btn-outline" id="cancelProfileEditButton" type="button">Cancel</button>
          <button class="btn btn-primary" id="saveProfileButton" type="submit">Save changes</button>
        </div>
      </form>
    </article>
  </div></div>
</section>

<section class="page" id="page-change-password">
  <div class="page-head"><div class="wrap">
    <div>
      <h1>Change Password</h1>
      <p>Update your password to keep your account secure.</p>
    </div>
  </div></div>
  <div class="page-body"><div class="wrap">
    <article class="card profile-card profile-password-card" aria-labelledby="passwordSettingsTitle">
      <div class="profile-password-heading">
        <div>
          <h2 id="passwordSettingsTitle">Security</h2>
          <p>Enter your current password, then choose a new one.</p>
        </div>
      </div>
      <form class="profile-edit-form profile-password-form" id="changePasswordForm">
        <div class="profile-edit-fields">
          <div class="form-row">
            <label for="currentPassword">Current password</label>
            <input id="currentPassword" name="current_password" type="password" autocomplete="current-password" required>
            <small class="err" data-error-for="current_password"></small>
          </div>
          <div class="form-row">
            <label for="newPassword">New password</label>
            <input id="newPassword" name="password" type="password" autocomplete="new-password" minlength="10" required>
            <small class="err" data-error-for="password"></small>
          </div>
          <div class="form-row">
            <label for="newPasswordConfirmation">Confirm new password</label>
            <input id="newPasswordConfirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="10" required>
          </div>
        </div>
        <p class="profile-edit-feedback" id="changePasswordFeedback" role="status" aria-live="polite" hidden></p>
        <div class="profile-edit-actions">
          <button class="btn btn-primary" id="changePasswordButton" type="submit">Change password</button>
        </div>
      </form>
    </article>
  </div></div>
</section>

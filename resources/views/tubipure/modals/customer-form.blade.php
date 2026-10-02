<div class="overlay" id="customerModal">
  <div class="modal">
    <div class="modal-head"><h3 id="custModalTitle">Add new customer</h3><button class="modal-close" data-close>&times;</button></div>
    <div class="modal-body">
      <input type="hidden" id="custId">
      <div class="form-row" id="fld-custName">
        <label>Full name</label>
        <input type="text" id="custName" maxlength="255" placeholder="e.g. Maria Santos">
        <div class="err">Please enter the customer's name.</div>
      </div>
      <div class="form-row" id="fld-custAddress">
        <label>Address</label>
        <input type="text" id="custAddress" maxlength="255" placeholder="Purok / Street, Barangay">
        <div class="err">Please enter an address.</div>
      </div>
      <div class="form-row" id="fld-custContact">
        <label>Contact number</label>
        <input type="tel" id="custContact" maxlength="11" placeholder="09XXXXXXXXX">
        <div class="err">Enter a valid 11-digit contact number.</div>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn btn-ghost" data-close>Cancel</button>
      <button class="btn btn-primary" id="saveCustomerBtn">Save customer</button>
    </div>
  </div>
</div>

@extends('layouts.tubipure')

@section('content')
    @include('tubipure.pages.home')
    @include('tubipure.pages.dashboard')
    @include('tubipure.pages.customers')
    @include('tubipure.pages.users')
    @include('tubipure.pages.scheduler')
    @include('tubipure.pages.order-history')
    @include('tubipure.pages.kmr')
    @include('tubipure.pages.datetime')
    @include('tubipure.pages.myaccount')
    @include('tubipure.pages.order')
    @include('tubipure.pages.profile')
    @include('tubipure.pages.change-password')
    @include('tubipure.pages.address')
    @include('tubipure.pages.about')
    @include('tubipure.pages.contact')
    <dialog class="order-map-dialog" id="orderMapDialog" aria-labelledby="orderMapTitle">
      <section class="order-map-card">
        <header class="order-map-heading"><div><span id="orderMapEyebrow">ORDER LOCATION</span><h2 id="orderMapTitle">View location</h2><p id="orderMapAddress"></p></div><button id="closeOrderMap" type="button" aria-label="Close map">×</button></header>
        <p class="order-map-feedback" id="orderMapFeedback" role="status" aria-live="polite"></p>
        <div class="order-map-summary" id="orderMapSummary" hidden></div>
        <div class="order-map-canvas" id="orderMapCanvas" aria-label="Order location map">
          <div class="order-map-tiles" id="orderMapTiles" aria-hidden="true"></div>
          <svg class="order-map-route" id="orderMapRoute" aria-hidden="true"></svg>
          <div class="order-map-markers" id="orderMapMarkers" aria-hidden="true"></div>
          <span class="order-map-attribution">© OpenStreetMap contributors · Routing by OSRM</span>
        </div>
      </section>
    </dialog>
    <dialog class="time-picker-dialog" id="orderTimeDialog" aria-labelledby="timePickerTitle">
      <div class="time-picker-card">
        <div class="time-picker-heading"><div><span id="timePickerEyebrow">ORDER SCHEDULE</span><h2 id="timePickerTitle">Choose a time</h2></div><button class="time-picker-close" id="orderTimeCloseBtn" type="button" aria-label="Close time picker">×</button></div>
        <div class="time-picker-readout" aria-live="polite"><button id="timePickerHour" type="button" aria-label="Choose hour">08</button><span>:</span><button id="timePickerMinute" type="button" aria-label="Choose minutes">00</button><span class="time-picker-period-options" role="group" aria-label="Choose AM or PM"><button class="time-picker-period" id="timePickerAmBtn" type="button" aria-pressed="true">AM</button><button class="time-picker-period" id="timePickerPmBtn" type="button" aria-pressed="false">PM</button></span></div>
        <p class="time-picker-instruction" id="timePickerInstruction">Choose a time during delivery availability.</p>
        <div class="time-picker-face" id="timePickerFace" role="group" aria-label="12-hour time picker"></div>
        <div class="time-picker-actions"><button class="btn btn-ghost" id="orderTimeCancelBtn" type="button">Cancel</button><button class="btn btn-primary" id="orderTimeNextBtn" type="button">Next</button><button class="btn btn-primary" id="orderTimeSetBtn" type="button" hidden>Set time</button></div>
      </div>
    </dialog>
@endsection

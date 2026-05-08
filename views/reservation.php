<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grand Luxe - Guest Portal</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/style.css">
  <script src="../public/reservation.js"></script>
  
</head>
<body>
  <div class="ambient"></div>
  <div class="grid-overlay"></div>
  <div id="guest-app" style="height:100vh; display:flex; flex-direction:column;">
    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-logo">⬡ Grand Luxe</div>
      <div class="topbar-nav">
        <div class="tnav active" data-page="rooms">🛏 Rooms</div>
        <div class="tnav" data-page="bookings">📋 My Bookings</div>
        <div class="tnav" data-page="profile">👤 Profile</div>
      </div>
      <div class="topbar-user" id="user-menu">
        <div class="tav" id="user-avatar">G</div>
        <span id="user-name">Guest</span>
      </div>
    </div>
    <!-- Main Content -->
    <div class="app-body">
      <!-- Rooms Page -->
      <div class="subpage active" id="page-rooms">
        <div class="section-header">
          <h1>Available Rooms</h1>
          <p>Choose your perfect stay — prices per night</p>
        </div>

        <div class="filter-bar">
          <div class="filter-group">
            <label>Check-in</label>
            <input type="date" id="filter-checkin">
          </div>
          <div class="filter-group">
            <label>Check-out</label>
            <input type="date" id="filter-checkout">
          </div>
          <div class="filter-group">
            <label>Room Type</label>
            <select id="filter-type">
              <option value="">All Types</option>
              <option>standard</option>
              <option>deluxe</option>
              <option>suite</option>
              <option>penthouse</option>
            </select>
          </div>
          <button class="btn btn-g" id="search-rooms">Search</button>
        </div>
        <div class="rooms-grid" id="rooms-container"></div>
      </div>
      <!-- Booking Page -->
      <div class="subpage" id="page-booking">
        <div style="margin-bottom: 20px;">
          <button class="btn btn-o" id="back-to-rooms">← Back to Rooms</button>
        </div>
        <div class="booking-layout">
          <div class="booking-form">
            <h2 style="font-family:'Playfair Display'; margin-bottom:20px;">Complete Your Booking</h2>
            <div class="fgrid">
              <div class="fg"><label>First Name</label><input type="text" id="book-firstname"></div>
              <div class="fg"><label>Last Name</label><input type="text" id="book-lastname"></div>
              <div class="fg"><label>Email</label><input type="email" id="book-email"></div>
              <div class="fg"><label>Phone</label><input type="tel" id="book-phone" placeholder="+20 100 000 0000"></div>
            </div>
            <div class="divider"></div>
            <div class="fgrid">
              <div class="fg"><label>Check-in</label><input type="date" id="book-checkin"></div>
              <div class="fg"><label>Check-out</label><input type="date" id="book-checkout"></div>
              <div class="fg ffull"><label>Special Requests</label><textarea rows="3" id="book-requests" placeholder="Any special requests?"></textarea></div>
            </div>

            <button class="btn btn-g" id="confirm-booking" style="width:100%; margin-top:20px; padding:12px;">Confirm Booking</button>
          </div>
          <div class="booking-summary">
            <div class="summary-img"><span id="summary-emoji">🏨</span></div>
            <div style="font-size:11px; color:var(--gold);" id="summary-type">Room Type</div>
            <div style="font-size:16px; font-family:'Playfair Display'; margin-bottom:12px;" id="summary-name">Room Name</div>
            <div class="summary-row"><span>Per Night</span><span id="summary-price">$0</span></div>
            <div class="summary-row"><span>Nights</span><span id="summary-nights">—</span></div>
            <div class="summary-row"><span>Subtotal</span><span id="summary-subtotal">$0</span></div>
            <div class="summary-row"><span>Tax (14%)</span><span id="summary-tax">$0</span></div>
            <div class="summary-total"><span>Total</span><span id="summary-total">$0</span></div>
          </div>
        </div>
      </div>
      
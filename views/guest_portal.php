<?php
require_once '../controller/GuestController.php';
$controller = new GuestController();

if (isset($_POST['save_profile'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    
    $controller->updateProfile(1, $fname, $lname, $email); 
    
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('Profile updated successfully! ✨');
    });
</script>";
}

$guestData = $controller->showProfile(1); 

$bookings = $controller->showBookings(1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grand Luxe - Guest Portal</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="ambient"></div>
  <div class="grid-overlay"></div>

  <div id="guest-app" style="height:100vh; display:flex; flex-direction:column;">
    <div class="topbar">
      <div class="topbar-logo">⬡ Grand Luxe</div>
      <div class="topbar-nav">
        <div class="tnav active" data-page="rooms">🛏 Rooms</div>
        <div class="tnav" data-page="bookings">📋 My Bookings</div>
        <div class="tnav" data-page="profile">👤 Profile</div>
      </div>
      <div class="topbar-user" id="user-menu">
        <div class="tav" id="user-avatar">G</div>
<span id="user-name"><?php echo $guestData['fname'] . " " . $guestData['lname']; ?></span> </div>
    </div>

    <div class="app-body">
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
              <option>Standard</option>
              <option>Deluxe</option>
              <option>Suite</option>
              <option>Penthouse</option>
            </select>
          </div>
          <button class="btn btn-g" id="search-rooms">Search</button>
        </div>
        <div class="rooms-grid" id="rooms-container"></div>
      </div>

      <div class="subpage" id="page-booking">
        <div style="margin-bottom: 20px;">
          <button class="btn btn-o" id="back-to-rooms">← Back to Rooms</button>
        </div>
        <div class="booking-layout">
          <div class="booking-form">
            <h2 style="font-family:'Playfair Display'; margin-bottom:20px;">Complete Your Booking</h2>
            <div class="fgrid">
              <div class="fg"><label>First Name</label><input type="text" id="book-firstname" value="<?php echo $guestData['fname']; ?>"></div>
              <div class="fg"><label>Last Name</label><input type="text" id="book-lastname" value="<?php echo $guestData['lname']; ?>"></div>
              <div class="fg"><label>Email</label><input type="email" id="book-email" value="<?php echo $guestData['email']; ?>"></div>
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

      <div class="subpage" id="page-bookings">
  <div class="section-header">
    <h1>My Bookings</h1>
    <p>Track and manage your reservations</p>
  </div>

  <div class="card">
    <div class="card-head">
      <div class="card-title">Reservation History</div>
    </div>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Reference</th>
            <th>Room</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody id="bookings-list">
    <?php if (empty($bookings)): ?>
        <tr><td colspan="7">No bookings found.</td></tr>
    <?php else: ?>
        <?php foreach ($bookings as $row): ?>
        <tr>
            <td>#<?php echo $row['res_id']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td> - </td>
            <td>$<?php echo $row['price']; ?></td>
            <td><span class="badge b-gold">Confirmed</span></td>
<td>
    <button class="btn btn-o btn-rate" data-res-id="<?php echo $row['res_id']; ?>" onclick="openRatingModal(this)">Rate</button>
</td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
      </table>
    </div>
  </div>
</div>

      <div class="subpage" id="page-profile">
        <div class="profile-layout">
          <div class="profile-card">
            <div class="profile-avatar" id="profile-avatar">G</div>
<h3 id="profile-name"><?php echo $guestData['fname'] . " " . $guestData['lname']; ?></h3>            <p style="color:var(--text-sub); font-size:12px;" id="profile-email">—</p>
            <div class="badge b-gold" id="profile-badge" style="margin-top:12px;">🪙 New Member</div>
            <div style="margin-top:20px; width:100%;">
              <div style="display:flex; justify-content:space-between; padding:8px 0;"><span>Role</span><span id="profile-role">Guest</span></div>
              <div style="display:flex; justify-content:space-between; padding:8px 0;"><span>Bookings</span><span id="profile-bookings">0</span></div>
            </div>
            <button class="btn btn-r" id="logout-btn" style="margin-top:20px; width:100%;">Sign Out</button>
          </div>
          <div class="card">
            <div class="card-head"><div class="card-title">Personal Information</div></div>
            <div class="card-body">
              <form method="POST" action="guest_portal.php">
    <div class="fgrid">
        <div class="fg">
            <label>First Name</label>
            <input type="text" name="fname" id="profile-fn" value="<?php echo $guestData['fname']; ?>">
        </div>
        <div class="fg">
            <label>Last Name</label>
            <input type="text" name="lname" id="profile-ln" value="<?php echo $guestData['lname']; ?>">
        </div>
        <div class="fg ffull">
            <label>Email</label>
            <input type="email" name="email" id="profile-em" value="<?php echo $guestData['email']; ?>">
        </div>
        <button type="submit" name="save_profile" class="btn btn-g" style="margin-top:16px;">Save Changes</button>
    </div>
</form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="toast"></div>
  
  <div id="rating-modal" class="modal">
  <div class="modal-box">

    <h3 style="font-family:'Playfair Display'; margin-bottom:10px;">
      Rate Your Stay
    </h3>
<input type="hidden" id="modal-res-id">
    <div class="stars">
      <span data-rate="1">★</span>
      <span data-rate="2">★</span>
      <span data-rate="3">★</span>
      <span data-rate="4">★</span>
      <span data-rate="5">★</span>
    </div>

    <textarea placeholder="Write your feedback..." rows="4"></textarea>

    <div class="modal-actions">
      <button class="btn btn-o" id="close-rate">Cancel</button>
      <button class="btn btn-g" id="submit-rate">Submit</button>
    </div>

  </div>
</div>
<script src="../script.js"></script>
  <script>
    
// PAGE SWITCH ONLY
document.querySelectorAll('.tnav').forEach(btn => {
  btn.addEventListener('click', () => {
    const pageId = btn.getAttribute('data-page');

    document.querySelectorAll('.subpage')
      .forEach(p => p.classList.remove('active'));

    const page = document.getElementById('page-' + pageId);
    if (page) page.classList.add('active');

    document.querySelectorAll('.tnav')
      .forEach(t => t.classList.remove('active'));

    btn.classList.add('active');
  });
});


// TOAST ONLY
window.showToast = function(msg) {
  let t = document.getElementById('toast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'toast';
    document.body.appendChild(t);
  }

  t.textContent = msg;
  t.className = 'show';
  setTimeout(() => t.className = '', 2000);
};

// ===== RATING MODAL UI =====

function openRatingModal(btn) {
    const resId = btn.getAttribute('data-res-id');
    document.getElementById('modal-res-id').value = resId;
    document.getElementById('rating-modal').style.display = 'flex';
}

document.getElementById('close-rate')?.addEventListener('click', () => {
    document.getElementById('rating-modal').style.display = 'none';
});

document.querySelectorAll('.stars span').forEach(star => {
    star.onclick = function() {
        document.querySelectorAll('.stars span').forEach(s => {
            s.classList.remove('active');
            s.style.color = "#444"; 
        });
        
        this.classList.add('active');
        let current = this;
        while(current) {
            current.style.color = "#d4af37"; 
            current = current.previousElementSibling;
        }
    };
});

// 4. Submit Feedback to Server
document.getElementById('submit-rate')?.addEventListener('click', (e) => {
    e.preventDefault();  
    
    const resId = document.getElementById('modal-res-id').value;
    const rating = document.querySelector('.stars span.active')?.dataset.rate || 5;
    const feedback = document.querySelector('#rating-modal textarea').value;

    if(!feedback) {
        showToast("Please write your feedback first! ✍️");
        return;
    }

    fetch('save_feedback.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `res_id=${resId}&rating=${rating}&comment=${feedback}`
    })
    .then(() => {
        showToast("Thank you for your feedback! ⭐");
        
        document.getElementById('rating-modal').style.display = 'none';
        
        document.querySelector('#rating-modal textarea').value = '';
    });
});
  </script>
</body>
</html>
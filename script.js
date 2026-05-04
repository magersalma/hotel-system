// ========== DATA ==========
window.ROOMS_DATA = [
  { id: 1, type: 'Standard', name: 'Classic Standard Room', emoji: '🛏', price: 140, capacity: 2, features: ['Free WiFi', 'TV', 'Air Conditioning'], desc: 'Comfortable room with modern amenities.', available: true },
  { id: 2, type: 'Standard', name: 'Garden View Standard', emoji: '🌿', price: 165, capacity: 2, features: ['Garden View', 'Free WiFi', 'TV'], desc: 'Peaceful garden view.', available: true },
  { id: 3, type: 'Deluxe', name: 'Deluxe City View', emoji: '🌆', price: 240, capacity: 2, features: ['City View', 'King Bed', 'Bathtub'], desc: 'Stunning city panorama.', available: true },
  { id: 4, type: 'Deluxe', name: 'Deluxe Twin Room', emoji: '✨', price: 220, capacity: 3, features: ['Twin Beds', 'Sitting Area', 'Free WiFi'], desc: 'Spacious deluxe room.', available: true },
  { id: 5, type: 'Suite', name: 'Grand Luxe Suite', emoji: '🏆', price: 480, capacity: 2, features: ['Living Room', 'Jacuzzi', 'Butler'], desc: 'The pinnacle of luxury.', available: true },
  { id: 6, type: 'Suite', name: 'Executive Suite', emoji: '💼', price: 420, capacity: 3, features: ['Office Desk', 'Lounge Area', 'Premium WiFi'], desc: 'Designed for business travelers.', available: true },
  { id: 7, type: 'Penthouse', name: 'Royal Penthouse', emoji: '👑', price: 1200, capacity: 4, features: ['Private Terrace', 'Private Pool', 'Chef'], desc: 'Unparalleled experience.', available: true },
  { id: 8, type: 'Deluxe', name: 'Honeymoon Deluxe', emoji: '🌹', price: 310, capacity: 2, features: ['Rose Petal Setup', 'Champagne', 'Jacuzzi'], desc: 'A dreamy retreat for couples.', available: false }
];

// Load or initialize Database
let savedDB = localStorage.getItem('hotelDB');
if (savedDB) {
  window.DB = JSON.parse(savedDB);
} else {
  window.DB = {
    users: [
      { id: 'u0', firstName: 'Ahmed', lastName: 'Manager', email: 'manager@hotel.com', role: 'manager', password: '123456', blacklisted: false },
      { id: 'u1', firstName: 'Amira', lastName: 'Hassan', email: 'guest@hotel.com', role: 'guest', password: '123456', blacklisted: false }
    ],
    bookings: [],
    blacklist: []
  };
}

// ========== HELPER FUNCTIONS ==========
window.saveToLocalStorage = function() {
  localStorage.setItem('hotelDB', JSON.stringify({ 
    users: window.DB.users, 
    bookings: window.DB.bookings, 
    blacklist: window.DB.blacklist 
  }));
};

window.getCurrentUser = function() {
  const saved = localStorage.getItem('currentUser');
  if (saved) {
    const userData = JSON.parse(saved);
    return window.DB.users.find(u => u.id === userData.id) || null;
  }
  return null;
};

window.setCurrentUser = function(user) {
  if (user) {
    const safeUser = { id: user.id, firstName: user.firstName, lastName: user.lastName, email: user.email, role: user.role };
    localStorage.setItem('currentUser', JSON.stringify(safeUser));
    window.currentUser = user;
  } else {
    localStorage.removeItem('currentUser');
    window.currentUser = null;
  }
};

window.logout = function() {
  localStorage.removeItem('currentUser');
  window.currentUser = null;
  window.location.href = 'index.html';
};

window.showToast = function(message, type = 'success') {
  let toast = document.getElementById('toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast';
    document.body.appendChild(toast);
  }
  toast.textContent = message;
  toast.className = 'show ' + type;
  setTimeout(() => toast.className = '', 3000);
};

window.formatDate = function(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
};

window.getDaysFromNow = function(days) {
  const d = new Date();
  d.setDate(d.getDate() + days);
  return d.toISOString().split('T')[0];
};

window.statusBadge = function(status) {
  const badges = {
    pending: '<span class="badge b-gold">Pending</span>',
    confirmed: '<span class="badge b-green">Confirmed</span>',
    cancelled: '<span class="badge b-red">Cancelled</span>'
  };
  return badges[status] || '<span class="badge">' + status + '</span>';
};
window.showToast = function(message) {
  let toast = document.getElementById('toast');

  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast';
    document.body.appendChild(toast);
  }

  toast.textContent = message;
  toast.className = 'toast-show';

  setTimeout(() => {
    toast.className = '';
  }, 2500);
};

window.formatDate = function(dateStr) {
  if (!dateStr) return '';

  const date = new Date(dateStr);

  return date.toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};

window.getDaysFromNow = function(days) {
  const date = new Date();
  date.setDate(date.getDate() + days);

  return date.toISOString().split('T')[0];
};

window.statusBadge = function(status) {

  const styles = {
    pending: 'color:#f5c542',
    confirmed: 'color:#4caf7d',
    cancelled: 'color:#e05a5a'
  };

  const color = styles[status] || '#aaa';

  return `<span style="padding:4px 10px; border:1px solid ${color}; border-radius:20px; font-size:11px; color:${color}">
            ${status}
          </span>`;
};
const currentServices = [];
const currentServicesTable = document.getElementById("current-services");
const chargeTotal = document.getElementById("charge-total");

const serviceType = document.getElementById("service-type");
const itemName = document.getElementById("item-name");
const qty = document.getElementById("qty");
const unitPrice = document.getElementById("unit-price");

document.getElementById("add-service").addEventListener("click", () => {
  const service = serviceType.value;
  const item = itemName.value.trim();
  const quantity = Number(qty.value);
  const price = Number(unitPrice.value);

  if (!item || quantity <= 0 || price <= 0) {
    alert("Please fill item, quantity and unit price.");
    return;
  }

  const total = quantity * price;

  currentServices.push({
    service,
    item,
    quantity,
    price,
    total
  });

  renderServices();

  itemName.value = "";
  qty.value = "";
  unitPrice.value = "";
});

function renderServices() {
  currentServicesTable.innerHTML = "";

  let grandTotal = 0;

  currentServices.forEach((row) => {
    grandTotal += row.total;

    currentServicesTable.innerHTML += `
      <tr>
        <td>${row.service}</td>
        <td>${row.item}</td>
        <td>${row.quantity}</td>
        <td>EGP ${row.price}</td>
        <td>EGP ${row.total}</td>
      </tr>
    `;
  });

  chargeTotal.textContent = `EGP ${grandTotal}`;
}

document.getElementById("save-charge").addEventListener("click", () => {
  const guestId = document.getElementById("guest-id").value.trim();
  const roomId = document.getElementById("room-id").value.trim();

  if (!guestId || !roomId || currentServices.length === 0) {
    alert("Enter guest, room, and at least one service.");
    return;
  }

  // Backend integration point (PHP / DB)
  console.log({
    guest_id: guestId,
    room_id: roomId,
    services: currentServices
  });

  // alert("Charges ready for backend saving.");
});
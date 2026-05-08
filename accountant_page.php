<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once '../Models/invoice.php';
require_once '../Models/payment.php';
require_once '../Models/accountant.php';
require_once '../Controllers/dbcontroller.php';



if (!isset($_SESSION['invoice_items'])) {
  $_SESSION['invoice_items'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {

  $service = $_POST['service'];
  $item = $_POST['item'];
  $qty = $_POST['qty'];
  $price = $_POST['price'];

  if (!empty($item) && $qty > 0 && $price > 0) {
    $lineTotal = $qty * $price;

    $_SESSION['invoice_items'][] = [
      'service' => $service,
      'item' => $item,
      'qty' => $qty,
      'price' => $price,
      'total' => $lineTotal
    ];
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {

  $guest_id = $_POST['guest_id'];
  $room_rate = $_POST['room_rate'];
  $acc_id = $_POST['acc_id'];
  $card_id = $_POST['card_id'];
  $payment_method = $_POST['payment_method'];

  $accountant = new Accountant($acc_id);

  if (!$accountant->validateAccountant()) {
    die("Invalid accountant account.");
  }

  $servicesTotal = 0;
  foreach ($_SESSION['invoice_items'] as $service) {
    $servicesTotal += $service['total'];
  }

  $invoice = new Invoice($guest_id,$room_rate,$servicesTotal,$acc_id,'Paid');

  $invoice_id = $invoice->createInvoice();

  if (!$invoice_id) {
    die("Invoice creation failed.");
  }

  $payment = new Payment($card_id,$payment_method,0,
    $invoice_id
  );

  if (!$payment->createPayment()) {
    die("Payment processing failed.");
  }

  $_SESSION['invoice_items'] = [];

  echo "Payment and invoice saved successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Invoice System</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="topbar">
    <div class="logo">⬡ Grand Luxe</div>
    <div>Accountant</div>
  </div>

  <div class="app-body">

    <!-- ADD SERVICE -->
    <div class="card">
      <div class="card-head">
        <div class="card-title">Add Service</div>
      </div>

      <div class="card-body">

        <div class="form-grid">

          <div class="fg">
            <label>Service</label>
            <select id="service">
              <option>Cafe</option>
              <option>Spa</option>
              <option>Minibar</option>
              <option>Laundry</option>
            </select>
          </div>

          <div class="fg">
            <label>Item</label>
            <input id="item" type="text">
          </div>

          <div class="fg">
            <label>Qty</label>
            <input id="qty" type="number">
          </div>

          <div class="fg">
            <label>Unit Price</label>
            <input id="price" type="number">
          </div>

        </div>

        <button class="btn" onclick="addToInvoice()">Add to Invoice</button>

      </div>
    </div>

    <br>

    <!-- INVOICE -->
    <div class="card">

      <div class="card-head">
        <div class="card-title">Live Invoice</div>
      </div>

      <div class="card-body">

        <table width="100%">
          <thead>
            <tr>
              <th>Service</th>
              <th>Item</th>
              <th>Qty</th>
              <th>Price</th>
              <th>Total</th>
            </tr>
          </thead>

          <tbody id="invoiceBody"></tbody>
        </table>

        <div style="margin-top:15px; font-size:20px;">
          Total:
          <span id="total">0</span> EGP
        </div>

        <button class="btn" style="margin-top:15px; background: #4CAF7D; color:#fff;">
          Checkout Invoice
        </button>

      </div>
    </div>

  </div>

  <script>
    let total = 0;

    function addToInvoice() {

      const service = document.getElementById("service").value;
      const item = document.getElementById("item").value;
      const qty = Number(document.getElementById("qty").value);
      const price = Number(document.getElementById("price").value);

      if (!item || qty <= 0 || price <= 0) return;

      const rowTotal = qty * price;
      total += rowTotal;

      document.getElementById("invoiceBody").innerHTML += `
    <tr>
      <td>${service}</td>
      <td>${item}</td>
      <td>${qty}</td>
      <td>${price}</td>
      <td>${rowTotal}</td>
    </tr>
  `;

      document.getElementById("total").innerText = total;

      // clear inputs
      document.getElementById("item").value = "";
      document.getElementById("qty").value = "";
      document.getElementById("price").value = "";
    }
  </script>

</body>

</html>
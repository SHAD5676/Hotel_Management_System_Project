<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}

// Get booking_id
$booking_id = $_GET['booking_id'] ?? 0;
$booking_id = intval($booking_id);
if($booking_id <= 0){
    $_SESSION['error']="Invalid Booking ID";
    header("Location: booking.php");
    exit;
}

// Fetch booking + customer + room + category + payments info
$stmt = $conn->prepare("
  SELECT b.booking_id, c.name AS customer_name, c.phone, c.email, c.address,
         r.room_number, rc.category_name, rc.price AS rate,
         b.check_in, b.check_out, b.total_price, b.booking_status
  FROM bookings b
  LEFT JOIN customers c ON b.customer_id=c.customer_id
  LEFT JOIN rooms r ON b.room_id=r.room_id
  LEFT JOIN room_categories rc ON r.category_id=rc.category_id
  WHERE b.booking_id=?
");
$stmt->bind_param("i",$booking_id);
$stmt->execute();
$billing = $stmt->get_result()->fetch_assoc();

if(!$billing){
    $_SESSION['error']="Booking not found";
    header("Location: booking.php");
    exit;
}

// Fetch payments
$payments_res = $conn->query("SELECT * FROM payments WHERE booking_id={$booking_id}");
$paid = 0;
$payment_rows = [];
while($p = $payments_res->fetch_assoc()){
    $paid += $p['amount'];
    $payment_rows[] = $p;
}

// Optional: fetch extra services for booking
$services_res = $conn->query("SELECT * FROM service_orders WHERE booking_id={$booking_id}");
$service_total = 0;
$service_rows = [];
while($s = $services_res->fetch_assoc()){
    $service_total += $s['price'] * $s['quantity'];
    $service_rows[] = $s;
}

// Calculate room total
$check_in = strtotime($billing['check_in']);
$check_out = strtotime($billing['check_out']);
$days = max(1, ($check_out - $check_in) / (60*60*24));
$room_total = $days * $billing['rate'];

// Grand total
$grand_total = $room_total + $service_total;
$due = $grand_total - $paid;
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice #<?= $billing['booking_id'] ?></title>
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<style>
.invoice-box { padding: 20px; border: 1px solid #eee; margin: 20px; }
@media print { .no-print { display:none; } }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<div class="invoice-box">
<h3>Invoice #<?= $billing['booking_id'] ?></h3>
<hr>

<h5>Customer Info</h5>
<p>
<strong>Name:</strong> <?= htmlspecialchars($billing['customer_name']) ?><br>
<strong>Phone:</strong> <?= htmlspecialchars($billing['phone']) ?><br>
<strong>Email:</strong> <?= htmlspecialchars($billing['email']) ?><br>
<strong>Address:</strong> <?= htmlspecialchars($billing['address']) ?><br>
</p>

<h5>Booking Details</h5>
<p>
<strong>Room:</strong> <?= htmlspecialchars($billing['room_number']) ?> (<?= htmlspecialchars($billing['category_name']) ?>)<br>
<strong>Check-in:</strong> <?= $billing['check_in'] ?><br>
<strong>Check-out:</strong> <?= $billing['check_out'] ?><br>
<strong>Days:</strong> <?= $days ?><br>
<strong>Rate per day:</strong> <?= number_format($billing['rate'],2) ?><br>
<strong>Room Total:</strong> <?= number_format($room_total,2) ?><br>
</p>

<?php if(count($service_rows) > 0): ?>
<h5>Extra Services</h5>
<table class="table table-bordered">
<tr>
<th>Service</th><th>Price</th><th>Quantity</th><th>Total</th>
</tr>
<?php foreach($service_rows as $s): ?>
<tr>
<td><?= htmlspecialchars($s['service_name']) ?></td>
<td><?= number_format($s['price'],2) ?></td>
<td><?= $s['quantity'] ?></td>
<td><?= number_format($s['price']*$s['quantity'],2) ?></td>
</tr>
<?php endforeach; ?>
<tr>
<th colspan="3">Service Total</th>
<th><?= number_format($service_total,2) ?></th>
</tr>
</table>
<?php endif; ?>

<h5>Payments</h5>
<?php if(count($payment_rows) > 0): ?>
<table class="table table-bordered">
<tr>
<th>Amount</th><th>Date</th><th>Method</th>
</tr>
<?php foreach($payment_rows as $p): ?>
<tr>
<td><?= number_format($p['amount'],2) ?></td>
<td><?= $p['payment_date'] ?></td>
<td><?= htmlspecialchars($p['method']) ?></td>
</tr>
<?php endforeach; ?>
<tr>
<th colspan="2">Total Paid</th>
<th><?= number_format($paid,2) ?></th>
</tr>
</table>
<?php else: ?>
<p>No payments recorded yet.</p>
<?php endif; ?>

<h5>Grand Summary</h5>
<p>
<strong>Grand Total:</strong> <?= number_format($grand_total,2) ?><br>
<strong>Paid:</strong> <?= number_format($paid,2) ?><br>
<strong>Due:</strong> <?= number_format($due,2) ?><br>
<strong>Status:</strong> <?= htmlspecialchars($billing['booking_status']) ?><br>
</p>

<div class="no-print mt-3">
<button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
<a href="booking.php" class="btn btn-secondary">Back to Bookings</a>
</div>
</div>
</div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js"></script>
</body>
</html>

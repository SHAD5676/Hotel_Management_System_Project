<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}

// Update room status automatically based on check-out date
$conn->query("UPDATE rooms r 
              JOIN bookings b ON r.room_id = b.room_id
              SET r.status = 'Available', b.booking_status = 'Checked Out'
              WHERE b.check_out <= CURDATE() AND b.booking_status = 'Booked'");

// Fetch all bookings
$sql = "SELECT b.booking_id, b.customer_id, b.check_in, b.check_out, b.total_price, b.booking_status,
               r.room_number
        FROM bookings b
        JOIN rooms r ON b.room_id = r.room_id
        ORDER BY b.booking_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Check In / Check Out</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Check In / Check Out</h3>

<table class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Room</th>
<th>Customer ID</th>
<th>Check In</th>
<th>Check Out</th>
<th>Total Price</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>{$i}</td>
                <td>{$row['room_number']}</td>
                <td>{$row['customer_id']}</td>
                <td>{$row['check_in']}</td>
                <td>{$row['check_out']}</td>
                <td>{$row['total_price']}</td>
                <td>{$row['booking_status']}</td>
                <td>";
        
        // Check In / Check Out buttons
        if($row['booking_status'] == 'Booked'){
            echo "<a href='update_booking_status.php?id={$row['booking_id']}&status=Checked In' class='btn btn-sm btn-success'>Check In</a>";
        }
        if($row['booking_status'] == 'Checked In'){
            echo "<a href='update_booking_status.php?id={$row['booking_id']}&status=Checked Out' class='btn btn-sm btn-warning'>Check Out</a>";
        }

        echo "</td></tr>";
        $i++;
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No bookings found</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
</body>
</html>

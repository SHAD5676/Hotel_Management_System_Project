<?php
include_once('db_config.php');
session_start();
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit();
}

// Handle form submission
if(isset($_POST['submit'])){
    $customer_id = intval($_POST['customer_id']);
    $booking_id  = intval($_POST['booking_id']);
    $rating      = intval($_POST['rating']);
    $comments    = mysqli_real_escape_string($conn, $_POST['comments']);
    $date        = date('Y-m-d H:i:s');

    // Insert into feedback table
    mysqli_query($conn, "INSERT INTO feedback (customer_id, booking_id, rating, comments, feedback_date) 
                         VALUES ($customer_id, $booking_id, $rating, '$comments', '$date')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback | Admin</title>
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Feedback / Reports</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- Feedback Form -->
      <div class="card">
        <div class="card-header bg-info text-white">
          <h3 class="card-title">Submit Feedback</h3>
        </div>
        <div class="card-body">
          <form method="post">
              <div class="form-group">
                  <label>Customer ID</label>
                  <input type="number" name="customer_id" class="form-control" required>
              </div>
              <div class="form-group">
                  <label>Booking ID</label>
                  <select name="booking_id" class="form-control" required>
                      <?php
                      $res = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
                      while($b = mysqli_fetch_assoc($res)){
                          echo "<option value='{$b['booking_id']}'>{$b['booking_id']}</option>";
                      }
                      ?>
                  </select>
              </div>
              <div class="form-group">
                  <label>Rating</label>
                  <select name="rating" class="form-control" required>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Comments</label>
                  <textarea name="comments" class="form-control" rows="3" required></textarea>
              </div>
              <button type="submit" name="submit" class="btn btn-success">Submit Feedback</button>
          </form>
        </div>
      </div>

      <!-- Feedback Table -->
      <div class="card mt-4">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title">All Feedback</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Feedback ID</th>
                <th>Customer ID</th>
                <th>Booking ID</th>
                <th>Rating</th>
                <th>Comments</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT * FROM feedback ORDER BY feedback_id DESC";
              $result = mysqli_query($conn, $query);

              if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                      $rating = intval($row['rating']);
                      $stars = str_repeat('&#9733;', $rating);
                      $emptyStars = str_repeat('&#9734;', 5 - $rating);

                      echo "<tr>
                              <td>{$row['feedback_id']}</td>
                              <td>{$row['customer_id']}</td>
                              <td>{$row['booking_id']}</td>
                              <td style='color:gold; font-size:1.2em;'>{$stars}{$emptyStars}</td>
                              <td>{$row['comments']}</td>
                              <td>{$row['feedback_date']}</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='6'>No feedback found</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>

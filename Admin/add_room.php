<?php
include_once('db_config.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
  $room_number = $_POST['room_number'];
  $category_id = $_POST['category_id'];
  $status = $_POST['status'];

  // Basic validation
  if (!empty($room_number) && !empty($category_id) && !empty($status)) {
    $stmt = $conn->prepare("INSERT INTO rooms (room_number, category_id, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $room_number, $category_id, $status);

    if ($stmt->execute()) {
      $success = "Room added successfully!";
    } else {
      $error = "Error: " . $stmt->error;
    }

    $stmt->close();
  } else {
    $error = "All fields are required.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Add New Room</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- AdminLTE style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- Navbar -->
    <?php include("includes/navbar.php"); ?>

    <!-- Main Sidebar Container -->
    <?php include("includes/leftbar.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Add New Room</h1>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Display success/error -->
          <?php if (isset($success)) { ?>
            <div class="alert alert-success"><?= $success ?></div>
          <?php } elseif (isset($error)) { ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php } ?>

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Room Details</h3>
            </div>

              <!-- form start -->
              <form method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="room_number">Room Number</label>
                    <input type="text" class="form-control" id="room_number" name="room_number" placeholder="Enter room number" required>
                  </div>

                  <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                      <option value="" disabled selected>Select Category</option>
                      <option value="Single">Single</option>
                      <option value="Double">Double</option>
                      <option value="Deluxe">Deluxe</option>
                      <option value="Suite">Suite</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                      <option value="" disabled selected>Select Status</option>
                      <option value="Available">Available</option>
                      <option value="Occupied">Occupied</option>
                      <option value="Maintenance">Maintenance</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Add Room</button>
                </div>
              </form>
            </div>

          </div>

        </div>
      </section>

    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
</body>

</html>
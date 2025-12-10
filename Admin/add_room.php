<?php
include_once('db_config.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:index.php');
}

if (isset($_POST['submit'])) {
  // Sanitize inputs
  $room_number = $conn->real_escape_string($_POST['room_number']);
  $category_id = $conn->real_escape_string($_POST['category_id']);
  $status = $conn->real_escape_string($_POST['status']);

  // Generate a room_id (you can adjust the format as needed)


  // Insert into database
  $sql = "INSERT INTO rooms ( room_number, category_id, status) 
            VALUES ('$room_number', '$category_id', '$status')";

  if ($conn->query($sql)) {
    echo "<div class='alert alert-success'>Room added successfully!</div>";
  } else {
    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
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

    <!-- Display success/error -->
    <?php if (isset($success)) { ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php } elseif (isset($error)) { ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>

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
                    <?php
                    // Fetch categories from the database
                    $cat_res = $conn->query("SELECT category_id, category_name FROM room_categories ORDER BY category_name ASC");
                    while ($cat = $cat_res->fetch_assoc()) {
                      echo "<option value='{$cat['category_id']}'>{$cat['category_name']}</option>";
                    }
                    ?>
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
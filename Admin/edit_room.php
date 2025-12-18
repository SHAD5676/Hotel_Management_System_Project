<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}

// Validate room_id
if (!isset($_GET['room_id']) || !is_numeric($_GET['room_id'])) {
  header('location:room.php');
  exit;
}

$room_id = (int) $_GET['room_id'];
$message = '';

// Fetch existing room data
$result = $conn->query("SELECT * FROM rooms WHERE room_id = $room_id");

if ($result->num_rows === 0) {
  header('location:room.php');
  exit;
}

$room = $result->fetch_assoc();

// Update room
if (isset($_POST['submit'])) {
  $room_number = trim($_POST['room_number']);
  $category_id = (int) $_POST['category_id'];
  $status = trim($_POST['status']);

  if ($room_number && $category_id && $status) {
    $room_number = $conn->real_escape_string($room_number);
    $status = $conn->real_escape_string($status);

    $sql = "UPDATE rooms 
                SET room_number='$room_number',
                    category_id='$category_id',
                    status='$status'
                WHERE room_id='$room_id'";

    if ($conn->query($sql)) {
      $_SESSION['success'] = "Room updated successfully!";
      header("Location: room.php");
      exit;
    } else {
      $message = "<div class='alert alert-danger'>Error: {$conn->error}</div>";
    }
  } else {
    $message = "<div class='alert alert-warning'>All fields are required.</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Admin | Edit Room</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
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
          <h1>Edit Room</h1>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <?= $message ?>

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Room Details</h3>
            </div>

            <form method="post">
              <div class="card-body">

                <div class="form-group">
                  <label>Room Number</label>
                  <input type="text" name="room_number" class="form-control"
                    value="<?= htmlspecialchars($room['room_number']) ?>" required>
                </div>

                <div class="form-group">
                  <label>Category</label>
                  <select name="category_id" class="form-control" required>
                    <?php
                    $cats = $conn->query("SELECT category_id, category_name FROM room_categories ORDER BY category_name");
                    while ($cat = $cats->fetch_assoc()) {
                      $selected = ($cat['category_id'] == $room['category_id']) ? 'selected' : '';
                      echo "<option value='{$cat['category_id']}' $selected>{$cat['category_name']}</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control" required>
                    <option value="Available" <?= $room['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                    <option value="Occupied" <?= $room['status'] == 'Occupied' ? 'selected' : '' ?>>Occupied</option>
                    <option value="Maintenance" <?= $room['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                  </select>
                </div>

              </div>

              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">
                  Update Room
                </button>
                <a href="room.php" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>

        </div>
      </section>
    </div>

    <?php include("includes/footer.php"); ?>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.js"></script>
</body>

</html>
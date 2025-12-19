<?php
include_once('db_config.php');
session_start();

// Validate room_id
if (!isset($_GET['room_id']) || !is_numeric($_GET['room_id'])) {
  header('Location: index.php');
  exit;
}

$room_id = (int) $_GET['room_id'];

// Fetch room info and first image
$sql = "SELECT r.room_id, r.room_number, r.status,
               c.category_name, c.price,
               ri.image_url
        FROM rooms r
        JOIN room_categories c ON r.category_id = c.category_id
        LEFT JOIN room_images ri ON r.room_id = ri.room_id
        WHERE r.room_id = $room_id
        LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
  header('Location: room.php');
  exit;
}

$room = $result->fetch_assoc();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Room Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php include_once 'Inc/top_nav.php'; ?>

  <main style="padding-top: 200px; padding-bottom: 100px">
    <div class="container">
      <!-- Back Button -->
      <div class="mb-4">
        <a href="room.php" class="btn btn-secondary">
          &larr; Back to Rooms
        </a>
      </div>

      <div class="row">
        <!-- Room Image -->
        <div class="col-md-6">
          <?php if (!empty($room['image_url']) && file_exists('./Admin/' . $room['image_url'])): ?>
            <img src="./Admin/<?= $room['image_url'] ?>" class="card-img-top" alt="Room Image" style="height:220px; object-fit:cover;">
          <?php else: ?>
            <img src="./Admin/<?= $room['image_url'] ?>" class="card-img-top" alt="Room Image" style="height:220px; object-fit:cover;">
          <?php endif; ?>
        </div>

        <!-- Room Details -->
        <div class="col-md-6">
          <h2>Room <?= htmlspecialchars($room['room_number']) ?></h2>
          <p><strong>Category:</strong> <?= htmlspecialchars($room['category_name']) ?></p>
          <p><strong>Price per night:</strong> $<?= number_format($room['price'], 2) ?></p>
          <p><strong>Status:</strong>
            <span class="badge <?= $room['status'] == 'Available' ? 'badge-success' : ($room['status'] == 'Occupied' ? 'badge-danger' : 'badge-warning') ?>">
              <?= $room['status'] ?>
            </span>
          </p>
          <form method="post" >
    <input type="hidden" name="room_id" value="<?= $room['room_id'] ?>">
    <input type="hidden" name="price" value="<?= $room['price'] ?>">

    <div class="form-group">
        <label for="nights">Number of nights:</label>
        <select name="nights" id="nights" class="form-control" required>
            <?php for ($i=1; $i<=30; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?> <?= $i==1?'night':'nights' ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3" <?= $room['status']!='Available'?'disabled':'' ?>>Book Now</button>

    <?php if($room['status']!='Available'): ?>
        <small class="text-danger d-block mt-2">This room is not available for booking.</small>
    <?php endif; ?>
</form>


          

        </div>
      </div>
    </div>
  </main>


  <?php include_once 'Inc/footer.php'; ?>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
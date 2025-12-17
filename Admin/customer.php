<?php
include_once('db_config.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}

// Fetch customers
$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Customers</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include("includes/navbar.php"); ?>
  <?php include("includes/leftbar.php"); ?>

  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customers</h1>
          </div>
          <div class="col-sm-6 text-right">
            <a href="customer_add.php" class="btn btn-primary">
              <i class="fas fa-plus"></i> Add Customer
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead class="bg-dark">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php if (mysqli_num_rows($customers) > 0): $i = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($customers)): ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= htmlspecialchars($row['name']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= htmlspecialchars($row['phone']) ?></td>
                  <td><?= htmlspecialchars($row['address']) ?></td>
                  <td>
                    <a href="customer_edit.php?id=<?= $row['customer_id']; ?>" class="btn btn-sm btn-info">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="customer_delete.php?id=<?= $row['customer_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this customer?')">
                      <i class="fas fa-trash"></i> Delete
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">No customers found</td>
                </tr>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
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

<?php
include_once('db_config.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}

// Fetch customers
$customers = mysqli_query($conn, "SELECT * FROM users ORDER BY users_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Users</title>

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
          <div class="col-sm-3">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6 text-right">
            <a href="users_add.php" class="btn btn-primary">
              
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
                  <th>User Id</th>
                  <th>Username</th>
                  <th>Password</th>
                  
                </tr>
              </thead>
              <tbody>
              <?php if (mysqli_num_rows($uers) > 0): $i = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($uers)): ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= htmlspecialchars($row['user_id']) ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td><?= htmlspecialchars($row['password']) ?></td>
                  <td>
                    <a href="user_edit.php?id=<?= $row['user_id']; ?>" class="btn btn-sm btn-info">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="user_delete.php?id=<?= $row['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">
                      <i class="fas fa-trash"></i> Delete
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">No users found</td>
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

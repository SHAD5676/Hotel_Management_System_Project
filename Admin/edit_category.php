<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
}

$message = '';

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('location:view_categories.php');
    exit;
}

$id = (int) $_GET['id'];

// Fetch existing category data
$result = $conn->query("SELECT * FROM room_categories WHERE category_id  = $id");

if ($result->num_rows == 0) {
    header('location:view_categories.php');
    exit;
}

$category = $result->fetch_assoc();

// Update category
if (isset($_POST['submit'])) {
    $category_name = $conn->real_escape_string($_POST['category_name']);
    $price = $conn->real_escape_string($_POST['price']);
    $details = $conn->real_escape_string($_POST['details']);

    if (!empty($category_name) && !empty($price)) {
        $sql = "UPDATE room_categories 
                SET category_name='$category_name', price='$price', details='$details' 
                WHERE id=$id";

        if ($conn->query($sql)) {
            $message = "<div class='alert alert-success'>Category updated successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: {$conn->error}</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please fill in all required fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin | Edit Category</title>
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
                    <h1>Edit Room Category</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php echo $message; ?>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category Details</h3>
                        </div>

                        <form method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="category_name"
                                        value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" step="0.01" class="form-control" name="price"
                                        value="<?php echo htmlspecialchars($category['price']); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Details</label>
                                    <textarea class="form-control" name="details" rows="3"><?php
                                                                                            echo htmlspecialchars($category['details']);
                                                                                            ?></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    Update Category
                                </button>
                                <a href="view_categories.php" class="btn btn-secondary">Cancel</a>
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
<?php
session_start();
include 'conn.php';

// Check if admin is logged in (you should implement admin login functionality)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); // Redirect to admin login page
    exit();
}

// Function to fetch orders from the database
function getOrders($conn) {
    $sql = "SELECT * FROM orders ORDER BY id DESC";
    $result = $conn->query($sql);
    return ($result->num_rows > 0) ? $result : false;
}

// Function to fetch products from the database
function getProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = $conn->query($sql);
    return ($result->num_rows > 0) ? $result : false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Admin!</h2>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="true">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="false">Manage Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_product.php">Add New Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h3>Orders</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Total Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $orders = getOrders($conn);
                        if ($orders) {
                            while ($row = $orders->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>{$row['address']}</td>";
                                echo "<td>{$row['total_price']}</td>";
                                echo "<td>{$row['created_at']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No orders found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                <h3>Manage Products</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $products = getProducts($conn);
                        if ($products) {
                            while ($row = $products->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['price']}</td>";
                                echo "<td>{$row['category']}</td>";
                                echo "<td>";
                                echo "<a href='edit_product.php?id={$row['id']}' class='btn btn-sm btn-info'>Edit</a> ";
                                echo "<a href='delete_product.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No products found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

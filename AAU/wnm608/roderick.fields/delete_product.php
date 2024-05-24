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

// Handle product deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare SQL statement to delete product
    $sql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to admin.php after successful deletion
        header("Location: admin.php");
        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}
?>

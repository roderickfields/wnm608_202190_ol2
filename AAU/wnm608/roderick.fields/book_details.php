<?php
session_start();
include 'parts/header.php';
include 'conn.php';

// Check if book ID is provided in the URL
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    // SQL query to retrieve book details by ID
    $sql = "SELECT * FROM products WHERE id = $book_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        // Redirect to error page if book not found
        header("Location: error.php");
        exit();
    }
} else {
    // Redirect to error page if book ID is not provided
    header("Location: error.php");
    exit();
}

// Check if the "Add to Cart" button is clicked
if (isset($_POST['add_to_cart'])) {
    // Add book to cart using session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    // Add book to cart array
    $_SESSION['cart'][] = $book_id;
    // Redirect to cart.php
    header("Location: cart.php");
    exit();
}
?>

<div class="container">
    <!-- Book details section -->
    <div class="row mt-5">
        <div class="col-md-8">
            <!-- Book image -->
            <img src="<?php echo $book['thumbnail']; ?>" alt="<?php echo $book['name']; ?>" class="img-fluid">
        </div>
        <div class="col-md-4">
            <!-- Book details -->
            <h2><?php echo $book['name']; ?></h2>
            <p>Price: $<?php echo $book['price']; ?></p>
            <p><?php echo $book['description']; ?></p>
            <!-- Add to Cart button -->
            <form method="post">
                <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php include 'parts/footer.php'; ?>

<?php
session_start();
include 'parts/header.php';
include 'conn.php';

// Check if action and bookId are provided in the URL
if (isset($_GET['action']) && isset($_GET['bookId'])) {
    $action = $_GET['action'];
    $bookId = $_GET['bookId'];

    // Check if cart session variable is set
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Check if the book is already in the cart
        $key = array_search($bookId, $_SESSION['cart']);
        if ($key !== false) {
            // Handle the action (increase or decrease)
            switch ($action) {
                case 'increase':
                    // Increase the count of the book in the cart
                    $_SESSION['cart'][] = $bookId;
                    break;
                case 'decrease':
                    // Decrease the count of the book in the cart
                    unset($_SESSION['cart'][$key]);
                    break;
            }
        }
    }

    // Redirect back to cart.php to refresh the cart display
    header("Location: cart.php");
    exit();
}

// Initialize total price and count for each item
$total_price_all_items = 0;
$total_count_all_items = 0;

?>

<div class="container mt-5">
    <h2>Shopping Cart</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php
                    // Check if cart is empty
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        // Initialize an array to keep track of book counts
                        $book_counts = array_count_values($_SESSION['cart']);
                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Book</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Count</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                        foreach ($book_counts as $book_id => $count) {
                            // Retrieve book details from the database
                            $sql = "SELECT * FROM products WHERE id = $book_id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $book = $result->fetch_assoc();
                                ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo $book['thumbnail']; ?>" class="img-fluid" style="max-width: 50px;" alt="<?php echo $book['name']; ?>">
                                        <span><?php echo $book['name']; ?></span>
                                    </td>
                                    <td>$<?php echo $book['price']; ?></td>
                                    <td><?php echo $count; ?></td>
                                    <td>$<?php echo number_format($book['price'] * $count, 2); ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Book Quantity">
                                            <a href="cart.php?action=decrease&bookId=<?php echo $book['id']; ?>" class="btn btn-sm btn-secondary">-</a>
                                            <span class="btn btn-sm btn-outline-secondary"><?php echo $count; ?></span>
                                            <a href="cart.php?action=increase&bookId=<?php echo $book['id']; ?>" class="btn btn-sm btn-secondary">+</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                // Accumulate total price and count for all items
                                $total_price_all_items += $book['price'] * $count;
                                $total_count_all_items += $count;
                            }
                        }
                        ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        // Display message if cart is empty
                        echo "<p>Your cart is empty.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cart Summary</h5>
                    <p>Total Items: <?php echo $total_count_all_items; ?></p>
                    <p>Total Price for All Items: $<?php echo number_format($total_price_all_items, 2); ?></p>
                    <a href="checkout.php" class="btn btn-primary">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'parts/footer.php'; ?>

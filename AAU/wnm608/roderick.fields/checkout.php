<?php
session_start();
include 'parts/header.php';
include 'conn.php';

// Initialize total price and count for all items
$total_price_all_items = 0;
$total_count_all_items = 0;
?>

<div class="container mt-5">
    <h2>Checkout</h2>
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Price</th>
                                    <th>Count</th>
                                    <th>Total</th>
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
                                    <td><?php echo $book['name']; ?></td>
                                    <td>$<?php echo number_format($book['price'], 2); ?></td>
                                    <td><?php echo $count; ?></td>
                                    <td>$<?php echo number_format($book['price'] * $count, 2); ?></td>
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
                    <h5 class="card-title">Order Summary</h5>
                    <p>Total Items: <?php echo $total_count_all_items; ?></p>
                    <p>Total Price for All Items: $<?php echo number_format($total_price_all_items, 2); ?></p>
                    <!-- Checkout form -->
                    <form action="process_checkout.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="PayPal">PayPal</option>
                                <!-- Add more payment options as needed -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'parts/footer.php'; ?>

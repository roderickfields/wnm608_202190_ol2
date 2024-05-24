<?php
session_start();
include 'conn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Check if total_price_all_items is set in the session
    if (!isset($_SESSION['total_price_all_items'])) {
        $_SESSION['total_price_all_items'] = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $book_counts = array_count_values($_SESSION['cart']);
            foreach ($book_counts as $book_id => $count) {
                $sql = "SELECT price FROM products WHERE id = $book_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $book = $result->fetch_assoc();
                    $_SESSION['total_price_all_items'] += $book['price'] * $count;
                }
            }
        }
    }

    $total_price_all_items = $_SESSION['total_price_all_items'];

    // Prepare and execute the order insertion
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, payment_method, total_price) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssd", $name, $email, $address, $payment_method, $total_price_all_items);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            // Insert order items
            $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            if ($stmt_item) {
                $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);

                foreach (array_count_values($_SESSION['cart']) as $product_id => $quantity) {
                    // Retrieve the product price from the database
                    $result = $conn->query("SELECT price FROM products WHERE id = $product_id");
                    if ($result->num_rows > 0) {
                        $product = $result->fetch_assoc();
                        $price = $product['price'];

                        // Execute the insertion of the order item
                        $stmt_item->execute();
                    }
                }

                // Clear the cart session
                unset($_SESSION['cart']);
                unset($_SESSION['total_price_all_items']);

                // Redirect to a thank you page after successful order placement
                header("Location: thank_you.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

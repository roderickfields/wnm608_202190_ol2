<?php
session_start();
include 'conn.php';

// Check if admin is already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php"); // Redirect to admin dashboard if already logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs (you can add more validation as needed)
    $errors = array();

    // Check if username is empty
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    // Check if password is empty
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check if confirm password is empty and matches password
    if (empty($confirm_password)) {
        $errors[] = "Please confirm password.";
    } elseif ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if there are any validation errors
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert admin into database
        $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        // Check if prepare() succeeded
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            // Registration successful, set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;

            // Redirect to admin dashboard
            header("Location: admin.php");
            exit();
        } else {
            $error = "Error registering admin: " . $stmt->error;
        }
    } else {
        // Display validation errors
        $error = implode("<br>", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Registration</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <br>
        <p>Already registered? <a href="login.php">Login Here</a></p>
        <p>Go to <a href="index.php">Home</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

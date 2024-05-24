<?php
session_start();
include 'conn.php';

// Check if admin is logged in (you should implement admin login functionality)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); // Redirect to admin login page
    exit();
}

// Initialize variables to hold form data and errors
$id = $name = $price = $category = $description = $thumbnail = $author = $publisher = $language = $format = $pages = '';
$errors = [];

// Function to upload thumbnail image
function uploadThumbnail() {
    $targetDir = "products_images/";
    $targetFile = $targetDir . basename($_FILES["thumbnail"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["thumbnail"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch product details from database based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $price = $row['price'];
        $category = $row['category'];
        $description = $row['description'];
        $thumbnail = $row['thumbnail'];
        $author = $row['author'];
        $publisher = $row['publisher'];
        $language = $row['language'];
        $format = $row['format'];
        $pages = $row['pages'];
    } else {
        echo "Product not found.";
        exit();
    }
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $price = $_POST['price'];
    $category = htmlspecialchars($_POST['category']);
    $description = htmlspecialchars($_POST['description']);
    $author = htmlspecialchars($_POST['author']);
    $publisher = htmlspecialchars($_POST['publisher']);
    $language = htmlspecialchars($_POST['language']);
    $format = htmlspecialchars($_POST['format']);
    $pages = $_POST['pages'];

    // Check if a new thumbnail is uploaded
    if (!empty($_FILES["thumbnail"]["name"])) {
        $thumbnail = uploadThumbnail(); // Call function to upload thumbnail
    }

    // Update product in database
    $date_modify = date('Y-m-d H:i:s');

    // Build SQL query for update
    $sql = "UPDATE products SET 
            name = '$name', 
            price = '$price', 
            category = '$category', 
            description = '$description', 
            author = '$author', 
            publisher = '$publisher', 
            language = '$language', 
            format = '$format', 
            pages = '$pages',
            date_modify = '$date_modify'";

    // Append thumbnail update to SQL query if new thumbnail is uploaded
    if (!empty($thumbnail)) {
        $sql .= ", thumbnail = '$thumbnail'";
    }

    $sql .= " WHERE id = $id";

    // Execute update query
    if ($conn->query($sql) === TRUE) {
        // Redirect to admin dashboard or show success message
        header("Location: admin.php");
        exit();
    } else {
        $errors[] = "Error updating product: " . $conn->error;
    }
}

include 'parts/header.php';
?>

<div class="container">
    <h2>Edit Product</h2>
    
    <!-- Display validation errors if any -->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error) {
                echo $error;
            } ?>
        </div>
    <?php endif; ?>

    <!-- Product Edit Form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" name="category" value="<?php echo $category; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $description; ?></textarea>
        </div>
        <div class="form-group">
            <label for="thumbnail">Current Thumbnail:</label><br>
            <img src="<?php echo $thumbnail; ?>" class="img-thumbnail" alt="Product Thumbnail" style="max-width: 200px;">
            <input type="file" class="form-control-file mt-2" id="thumbnail" name="thumbnail" accept="image/*">
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" class="form-control" id="author" name="author" value="<?php echo $author; ?>" required>
        </div>
        <div class="form-group">
            <label for="publisher">Publisher:</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo $publisher; ?>" required>
        </div>
        <div class="form-group">
            <label for="language">Language:</label>
            <input type="text" class="form-control" id="language" name="language" value="<?php echo $language; ?>" required>
        </div>
        <div class="form-group">
            <label for="format">Format:</label>
            <input type="text" class="form-control" id="format" name="format" value="<?php echo $format; ?>" required>
        </div>
        <div class="form-group">
            <label for="pages">Pages:</label>
            <input type="number" class="form-control" id="pages" name="pages" value="<?php echo $pages; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<?php include 'parts/footer.php'; ?>

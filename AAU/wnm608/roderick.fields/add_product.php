<?php
session_start();
include 'conn.php';

// Check if admin is logged in (you should implement admin login functionality)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); // Redirect to admin login page
    exit();
}

// Initialize variables to hold form data
$name = $price = $category = $description = $thumbnail = $author = $publisher = $language = $format = $pages = '';
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

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $name = htmlspecialchars($_POST['name']);
    $price = $_POST['price'];
    $category = htmlspecialchars($_POST['category']);
    $description = htmlspecialchars($_POST['description']);
    $thumbnail = uploadThumbnail(); // Call function to upload thumbnail
    $author = htmlspecialchars($_POST['author']);
    $publisher = htmlspecialchars($_POST['publisher']);
    $language = htmlspecialchars($_POST['language']);
    $format = htmlspecialchars($_POST['format']);
    $pages = $_POST['pages'];

    // Insert into database if thumbnail upload was successful
    if ($thumbnail) {
        $date_create = date('Y-m-d H:i:s');
        $date_modify = $date_create;

        $sql = "INSERT INTO products (name, price, category, date_create, date_modify, description, thumbnail, author, publisher, language, format, pages)
                VALUES ('$name', '$price', '$category', '$date_create', '$date_modify', '$description', '$thumbnail', '$author', '$publisher', '$language', '$format', '$pages')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to admin dashboard or show success message
            header("Location: admin.php");
            exit();
        } else {
            $errors[] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

include 'parts/header.php';
?>

<div class="container">
    <h2>Add New Product</h2>
    
    <!-- Display validation errors if any -->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error) {
                echo $error;
            } ?>
        </div>
    <?php endif; ?>

    <!-- Product Form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="thumbnail">Thumbnail Image:</label>
            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="form-group">
            <label for="publisher">Publisher:</label>
            <input type="text" class="form-control" id="publisher" name="publisher" required>
        </div>
        <div class="form-group">
            <label for="language">Language:</label>
            <input type="text" class="form-control" id="language" name="language" required>
        </div>
        <div class="form-group">
            <label for="format">Format:</label>
            <input type="text" class="form-control" id="format" name="format" required>
        </div>
        <div class="form-group">
            <label for="pages">Pages:</label>
            <input type="number" class="form-control" id="pages" name="pages" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>

<?php include 'parts/footer.php'; ?>

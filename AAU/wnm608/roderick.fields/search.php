<?php
session_start();
include 'parts/header.php';
include 'conn.php';

// Check if search query is provided
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // SQL query to retrieve books matching the search query
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
    $result = $conn->query($sql);
}
?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h2>Search Results</h2>
            <?php
            if (isset($result) && $result->num_rows > 0) {
                ?>
                <p>Showing results for: "<?php echo $search; ?>"</p>
                <div class="row">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <img src="<?php echo $row['thumbnail']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                                    <?php
                                    $book_id = $row['id'];
                                    $details_url = "book_details.php?id=$book_id";
                                    ?>
                                    <a href="<?php echo $details_url; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <p>No results found for: "<?php echo $search; ?>"</p>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include 'parts/footer.php'; ?>

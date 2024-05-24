<?php
session_start();
include 'parts/header.php';
include 'conn.php';

// Search functionality
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search_term%'";
} else {
    $sql = "SELECT * FROM products";
}

// Sort functionality
if (isset($_GET['sort'])) {
    $sort_by = $_GET['sort'];
    switch ($sort_by) {
        case 'price_asc':
            $sql .= " ORDER BY price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY price DESC";
            break;
            // Add more sorting options if needed
    }
}

// Filter functionality
if (isset($_GET['filter'])) {
    $filter_category = $_GET['filter'];
    $sql .= " WHERE category = '$filter_category'";
}

$result = $conn->query($sql);
?>

<div class="container">

    <style>
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }

        .card-title {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

    <!-- Featured books section -->
    <div class="container-2">
        <style>
            .container-2 {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .container-2>* {
                margin: 0 10px;
            }

            .dropdown {
                flex: 1;
            }

            .input-group {
                flex: 3;
            }

            .input-group-append {
                display: flex;
                align-items: center;
                margin-left: -1px;
            }

            .btn {
                white-space: nowrap;
            }
        </style>

        <div class="container-2">
            <!-- Search form -->
            <form method="get" action="" class="my-4 input-group">
                <input type="text" class="form-control" placeholder="Search books..." name="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>

            <!-- Sort dropdown -->
            <div class="dropdown my-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort by
                </button>
                <div class="dropdown-menu" aria-labelledby="sortDropdown">
                    <a class="dropdown-item" href="?sort=price_asc">Price: Low to High</a>
                    <a class="dropdown-item" href="?sort=price_desc">Price: High to Low</a>
                </div>
            </div>

            <!-- Filter dropdown -->
            <div class="dropdown my-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter by Category
                </button>
                <div class="dropdown-menu" aria-labelledby="filterDropdown">
                    <a class="dropdown-item" href="?filter=books">Books</a>
                    <a class="dropdown-item" href="?filter=electronics">Electronics</a>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-5">
        <?php
        if ($result->num_rows > 0) {
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
        } else {
            echo "No books found";
        }
        ?>
    </div>
</div>

</div>
<?php include 'parts/footer.php'; ?>
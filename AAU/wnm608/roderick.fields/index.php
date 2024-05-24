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
    <!-- Carousel section -->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="./assets/images/1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="./assets/images/2.jpg" alt="Second slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

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

    <!-- Customer reviews section -->
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h2>Customer Reviews</h2>
            <p>See what our customers have to say about us.</p>
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">"Great selection of books and excellent customer service from bookstore.!"</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Jane Smith</h5>
                            <p class="card-text">"Fast delivery and easy returns. Will definitely shop here again!"</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Michael Johnson</h5>
                            <p class="card-text">"Love the variety of genres available. Found exactly what I was looking for!"</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Emily Brown</h5>
                            <p class="card-text">"Impressed with the quality of books and the user-friendly website."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'parts/footer.php'; ?>
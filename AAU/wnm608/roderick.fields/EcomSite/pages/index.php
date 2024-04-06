<?php include '../parts/header.php'; ?>

<!-- Content for the index page goes here -->
<section>
    <div class="container">
        <h2>Welcome to EcomSite</h2>
        <p>This is the homepage of our e-commerce site.</p>
        
        <!-- Bootstrap Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <!-- Add more indicators if more carousel items are added -->
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../assets/images/1.png" class="d-block w-100" alt="Image 1">
                </div>
                <div class="carousel-item">
                    <img src="../assets/images/2.png" class="d-block w-100" alt="Image 2">
                </div>
                <!-- Add more carousel items as needed -->
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        
        <!-- More Content -->
        <div class="more-content mt-8">
            <h3 class="text-xl font-semibold">Featured Products</h3>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <!-- Add featured products here -->
            </div>
        </div>
        
    </div>
</section>

<?php include '../parts/footer.php'; ?>

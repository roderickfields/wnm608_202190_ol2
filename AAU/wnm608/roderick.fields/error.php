<?php
session_start();
include 'parts/header.php';
?>

<div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Error</h4>
        <p>Sorry, the page you are looking for could not be found.</p>
        <hr>
        <p class="mb-0">Please check the URL or return to the <a href="index.php" class="alert-link">home page</a>.</p>
    </div>
</div>

<?php include 'parts/footer.php'; ?>

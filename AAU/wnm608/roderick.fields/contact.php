<?php include 'parts/header.php'; ?>

<section>
    <div class="container">
        <h2>Contact Us</h2>
        <p>If you have any questions, feedback, or need assistance, please feel free to reach out to us using the contact information below or fill out our contact form.</p>
        
        <div class="row mt-5">
            <div class="col-md-6">
                <h3>Contact Information</h3>
                <p><strong>Email:</strong> support@ourbookstore.com</p>
                <p><strong>Phone:</strong> +1 (800) 123-4567</p>
                <p><strong>Address:</strong> 123 Book Street, Booktown, BK 12345</p>
            </div>
            <div class="col-md-6">
                <h3>Contact Form</h3>
                <form action="send_message.php" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'parts/footer.php'; ?>

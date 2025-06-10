<?php
/**
 * @var string $errorMessage
 */
?>
<section class="error-section d-flex flex-column align-items-center justify-content-center text-center py-5">
    <h1 style="font-size: 6em; margin-bottom: 0;">404</h1>
    <h2>Page Not Found</h2>
    <p class="lead mt-3"><?php echo htmlspecialchars($errorMessage); ?></p>
    <p>We're sorry, but the page you were looking for could not be found.</p>
    <a href="/" class="btn">Go to Homepage</a>
</section>
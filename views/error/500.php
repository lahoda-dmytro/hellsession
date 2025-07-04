<?php
/**
 * @var string $errorMessage
 */
?>
<section class="error-section d-flex flex-column align-items-center justify-content-center text-center py-5">
    <h1 style="font-size: 6em; margin-bottom: 0;">500</h1>
    <h2>Internal Server Error</h2>
    <p class="lead mt-3"><?php echo htmlspecialchars($errorMessage); ?></p>
    <p>Something went wrong on our server. We are working to fix this.</p>
    <a href="/" class="btn">Go to Homepage</a>
</section>
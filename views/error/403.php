<?php
/**
 * @var string $errorMessage
 */
?>
<section class="error-section d-flex flex-column align-items-center justify-content-center text-center py-5">
    <h1 style="font-size: 6em; margin-bottom: 0;">403</h1>
    <h2>Forbidden</h2>
    <p class="lead mt-3"><?php echo htmlspecialchars($errorMessage); ?></p>
    <p>You don't have permission to access this resource.</p>
    <a href="/" class="btn">Go to Homepage</a>
</section>
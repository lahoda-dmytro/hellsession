<?php
/**
 * @var string $errorMessage
 */
?>
<section class="error-section d-flex flex-column align-items-center justify-content-center text-center py-5">
    <h1 style="font-size: 6em; margin-bottom: 0;">405</h1>
    <h2>Method Not Allowed</h2>
    <p class="lead mt-3"><?php echo htmlspecialchars($errorMessage); ?></p>
    <p>The HTTP method used for this request is not allowed.</p>
    <a href="/" class="btn">Go to Homepage</a>
</section>
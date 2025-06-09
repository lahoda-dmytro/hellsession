<div class="text-center mt-5">
    <h1>Помилка оплати</h1>
    <p>Виникла помилка під час обробки платежу.</p>
    <?php if (isset($error)): ?>
        <p>Деталі помилки: <?= $error ?></p>
    <?php endif; ?>
    <p><a href="/?route=site/index">Home Page</a></p>
</div>
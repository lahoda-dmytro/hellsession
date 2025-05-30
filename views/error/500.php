<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>500</title>
</head>
<body>
    <h1>Помилка 500</h1>
    <p>На жаль, на сервері сталася внутрішня помилка.</p>
    <p>Ми вже працюємо над її виправленням.</p>
    <p>Спробуйте оновити сторінку або поверніться на <a href="/">головну</a>.</p>
    <?php if (isset($errorMessage)): ?>
        <p style="color: #d9534f; font-weight: bold;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
</body>
</html>

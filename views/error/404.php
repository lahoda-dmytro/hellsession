<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 Not Found</title>
</head>
<body>
    <h1>Помилка 404 - Сторінка не знайдена</h1>
    <p>На жаль, запитувана вами сторінка не існує.</p>
    <?php if (isset($errorMessage)): ?>
        <p>Деталі: <?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
    <p><a href="/">Повернутися на головну</a></p>
</body>
</html>

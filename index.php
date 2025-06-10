<?php
ob_start();

use classes\Core;
use classes\Cache;
use classes\Session;

spl_autoload_register(function ($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($path))
        require_once $path;

});

$core = Core::getInstance();
$session = Session::getInstance();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isUserLoggedIn = $session->get('user_id') !== null;

    $requestUri = $_SERVER['REQUEST_URI'];
    $parsedUrl = parse_url($requestUri);
    $path = $parsedUrl['path'] ?? '/';
    $path = trim($path, '/');
    $route = $_GET['route'] ?? '';

    $shouldCache = true;

    // не кешуємо, якщо користувач авторизований
    if ($isUserLoggedIn) {
        $shouldCache = false;
        error_log("Not caching because user is logged in.");
    }
    // не кешуємо сторінки кошика, профілю, замовлень
    else if (
        str_starts_with($route, 'cart') ||
        str_starts_with($route, 'profile') ||
        str_starts_with($route, 'order') ||
        str_starts_with($route, 'admin')
    ) {
        $shouldCache = false;
        error_log("Not caching because it's a dynamic user-specific page: " . $route);
    }

    if ($shouldCache) {
        $cache = Cache::getInstance();
        $cachedContent = $cache->get('page_' . md5($requestUri));

        if ($cachedContent !== null) {
            header('Content-Type: text/html; charset=utf-8');
            echo $cachedContent;
            ob_end_flush();
            exit();
        }
    }
}
$core->init();
$core->run();

$httpStatusCode = http_response_code();

$output = ob_get_clean();


if ($_SERVER['REQUEST_METHOD'] === 'GET' && $httpStatusCode === 200 && $shouldCache) {
    $cache->set('page_' . md5($requestUri), $output);
}

header('Content-Type: text/html; charset=utf-8');
echo $output;

exit();
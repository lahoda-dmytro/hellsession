<?php

namespace classes;

class JsonResponse {
    public static function send($data, int $statusCode = 200) {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }

    public static function error(string $message, int $statusCode = 400, array $extraData = []) {
        self::send(array_merge(['success' => false, 'message' => $message], $extraData), $statusCode);
    }

    public static function success(string $message = 'Операція успішна.', array $data = []) {
        self::send(array_merge(['success' => true, 'message' => $message], $data), 200);
    }
}
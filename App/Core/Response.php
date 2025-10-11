<?php
namespace App\Core;

class Response {

    public function setStatusCode(int|string $code): void {
        http_response_code((int)$code);
    }

    public function getStatusCode(): int {
        return http_response_code();
    }

    public function redirect(string $url): void {
        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Location: ' . $url, true, 302);
        flush();
        exit;
    }
}

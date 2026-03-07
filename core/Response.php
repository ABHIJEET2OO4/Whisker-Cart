<?php
namespace Core;

/**
 * WHISKER — HTTP Response Helper
 */
class Response
{
    /** Send an HTML response */
    public static function html(string $content, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: text/html; charset=UTF-8');
        echo $content;
        exit;
    }

    /** Send a JSON response */
    public static function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /** Redirect to URL */
    public static function redirect(string $url, int $code = 302): void
    {
        http_response_code($code);
        header('Location: ' . $url);
        exit;
    }

    /** 404 Not Found */
    public static function notFound(string $message = 'Page not found'): void
    {
        http_response_code(404);
        echo $message; // TODO: render a proper 404 template
        exit;
    }

    /** 403 Forbidden */
    public static function forbidden(string $message = 'Access denied'): void
    {
        http_response_code(403);
        echo $message;
        exit;
    }

    /** Set a response header */
    public static function header(string $name, string $value): void
    {
        header("{$name}: {$value}");
    }
}

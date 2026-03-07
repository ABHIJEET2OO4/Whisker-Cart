<?php
namespace Core;

/**
 * WHISKER — Template Renderer
 *
 * Usage:
 *   View::render('admin/dashboard', ['stats' => $stats], 'admin/layouts/main');
 *   View::render('store/home', ['products' => $products], 'store/layouts/main');
 *   View::partial('store/partials/product-card', ['product' => $p]);
 */
class View
{
    /**
     * Render a view, optionally wrapped in a layout.
     *
     * @param string      $view   Path relative to views/ (e.g. 'admin/dashboard')
     * @param array       $data   Variables to extract into the view
     * @param string|null $layout Layout path relative to views/ (e.g. 'admin/layouts/main')
     */
    public static function render(string $view, array $data = [], ?string $layout = null): void
    {
        $data['_flashes'] = Session::getFlashes();
        $data['_csrf']    = Session::csrfToken();

        // Render the view content
        $content = self::capture($view, $data);

        if ($layout) {
            // Wrap content inside layout
            $data['_content'] = $content;
            echo self::capture($layout, $data);
        } else {
            echo $content;
        }
    }

    /**
     * Render a partial template (no layout).
     */
    public static function partial(string $view, array $data = []): string
    {
        return self::capture($view, $data);
    }

    /**
     * Capture a view's output into a string.
     */
    private static function capture(string $view, array $data): string
    {
        $file = WK_ROOT . '/views/' . $view . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException("View not found: {$view} ({$file})");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $file;
        return ob_get_clean();
    }

    /**
     * Helper: generate a URL path.
     */
    public static function url(string $path = ''): string
    {
        $base = defined('WK_BASE_URL') ? WK_BASE_URL : '';
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Helper: asset URL.
     */
    public static function asset(string $path): string
    {
        return self::url('assets/' . ltrim($path, '/'));
    }

    /**
     * Helper: escape output.
     */
    public static function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Helper: format price.
     */
    public static function price(float $amount, string $symbol = '₹'): string
    {
        return $symbol . number_format($amount, 2);
    }
}

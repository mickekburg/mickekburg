<?php
if (!function_exists('view')) {
    function view(string $path, array $args = []): \Core\Framework\Application\View\View
    {
        return new \Core\Framework\Application\View\View($path, $args);
    }
}
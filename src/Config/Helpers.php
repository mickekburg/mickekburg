<?php
if (!function_exists('view')) {
    function view(string $path, array $args = []): \Core\Framework\View\View
    {
        return new \Core\Framework\View\View($path, $args);
    }
}
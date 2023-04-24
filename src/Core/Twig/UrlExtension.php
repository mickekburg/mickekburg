<?php

namespace Core\Twig;

use Core\Framework\Helper\UrlHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UrlExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('site_url', [$this, 'formatUrl']),
        ];
    }

    public function formatUrl(string $url, bool $is_admin): string
    {
        if ($is_admin) {
            $url = ADMIN_PATH . "/" . trim($url, '/');
        }
        return UrlHelper::siteUrl($url);
    }
}
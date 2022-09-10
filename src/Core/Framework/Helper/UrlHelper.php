<?php

namespace Core\Framework\Helper;

final class UrlHelper
{
    private static string $base_url = "";

    public static function siteUrl(string $url): string
    {
        return self::baseUrl() . "/" . $url;
    }

    public static function baseUrl(): string
    {
        if (self::$base_url) {
            return self::$base_url;
        }
        self::$base_url = rtrim(\Application::i()->getRequest()->getSchemeAndHttpHost(), '/');
        return self::$base_url;
    }

    public static function currentUrl(): string
    {
        return self::siteUrl(\Application::i()->getRequest()->getPathInfo());
    }


}
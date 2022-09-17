<?php

namespace Module\Access\Service;

final class AccessService
{
    private static $instance;
    private static array $rools = [];

    public static function i(): self
    {
        if (self::$instance === null) {
            self::$instance = new static();
            self::init();
        }
        return self::$instance;
    }

    private static function init(): void
    {

    }

}
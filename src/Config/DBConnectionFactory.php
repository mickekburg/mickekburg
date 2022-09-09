<?php

namespace Config;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class DBConnectionFactory
{
    public const DEFAULT_DB = 'default';

    public static function getDbConfig(string $connection_name = self::DEFAULT_DB): Connection
    {
        switch ($connection_name) {
            case self::DEFAULT_DB:
                try {
                    return \Doctrine\DBAL\DriverManager::getConnection([
                        'dbname' => 'test',
                        'user' => 'root',
                        'password' => '',
                        'host' => 'localhost',
                        'driver' => 'pdo_mysql',
                    ]);
                } catch (Exception $e) {
                    throw new \Exception('Wrong database connection params');
                }
            default:
                throw new \Exception('Unknown DBConnectionFactory format given');
        }
    }
}
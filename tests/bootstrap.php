<?php

namespace Boxmeup\Test
{
    include __DIR__ . '/../vendor/autoload.php';

    function getConnection()
    {
        static $conn = null;

        if (!$conn) {
            $conn = \Doctrine\DBAL\DriverManager::getConnection([
                'dbname' => $GLOBALS['name'],
                'user' => $GLOBALS['user'],
                'password' => $GLOBALS['password'],
                'host' => $GLOBALS['host'],
                'driver' => 'pdo_mysql'
            ]);
        }

        return $conn;
    }
}

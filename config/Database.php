<?php
namespace Config;

use PDO;

class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {

        if (self::$instance === null) {

            self::$instance = new PDO(
                "mysql:host=localhost;dbname=peersync;charset=utf8",
                "root",
                ""
            );

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}
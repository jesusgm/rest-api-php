<?php

require_once __DIR__ . '/../config/config.php';

class DbConnection{
    // Singleton
    private static $connection;

    public static function get(){
        if(self::$connection == null){
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }
        return self::$connection;
    }
}
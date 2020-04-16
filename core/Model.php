<?php
    require_once __DIR__ . '/query.class.php';
    require_once __DIR__ . '/dbConnection.php';
    
    class Model {

        private $dbcon;
        private $table = "";

        function __construct($table) {
            $this->table = $table;

            $this->dbcon = DbConnection::get();
            return $this->dbcon;
        }

    }
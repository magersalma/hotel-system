<?php

class Database {

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "hotel";

    public function connect() {

        $conn = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->dbname
        );

        return $conn;
    }
}
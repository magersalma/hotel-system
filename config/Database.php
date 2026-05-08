<?php
class Database {
    private static $instance = null;
    private $connection;
    
    
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'hotel (2)'; 

    private function __construct() {
        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
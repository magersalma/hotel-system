<?php
class Database {
    private static $instance = null;
    private $connection;
    
    // بيانات الداتا بيز اللي شفناها في الـ phpMyAdmin
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'hotel'; // الاسم اللي ظهر عندك في الصور

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
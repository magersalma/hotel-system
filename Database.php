<?php
class Database {
    // المتغير ده هيشيل الـ Object الوحيد بتاعنا (عشان الـ Singleton)
    private static $instance = null;
    public $conn;

    // بيانات قاعدة البيانات بتاعتك اللي في ملف الـ SQL
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "hotel";

    // عملنا الـ Constructor (private) عشان نمنع أي حد يعمل Object جديد من بره
    // وده شرط أساسي في الـ Singleton Pattern اللي الكلية طالباه
    private function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        // لو فيه مشكلة في الاتصال، يوقف الكود ويطبع المشكلة
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // الدالة دي هي الباب الوحيد للمشروع.. لو الـ Object مش موجود بتعمله، ولو موجود بترجعه هو هو
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // الدالة دي اللي هننادي عليها من الـ Model عشان نكلم الداتا بيز
    public function getConnection() {
        return $this->conn;
    }
}
?>
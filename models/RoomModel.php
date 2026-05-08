<?php
// بننادي على ملف الداتا بيز عشان نعرف نكلمها
require_once '../config/Database.php';

class RoomModel {
    private $db;

    public function __construct() {
        // بنفتح الاتصال بالداتا بيز أول ما نستخدم الـ Model
        $this->db = Database::getInstance()->getConnection();
    }

    // وظيفة بتجيب كل الأوض اللي في جدول room
    public function getAllRooms() {
        $query = "SELECT * FROM room";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
}
?>
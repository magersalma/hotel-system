<?php
require_once '../config/db.php';

class EmployeeModel {

    public static function getByEmail($email) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM employee WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getById($id) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM employee WHERE emp_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getAll() {
        $conn = Database::getConnection();
        $result = $conn->query("SELECT * FROM employee");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getByPosition($position) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM employee WHERE position = ?");
        $stmt->bind_param("s", $position);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<?php
require_once '../config/db.php';

class GuestModel {

    public static function getByEmail($email) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM guest WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getById($id) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM guest WHERE guest_num = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($fname, $lname, $email, $password) {
        $conn = Database::getConnection();
        $check = $conn->prepare("SELECT guest_num FROM guest WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            return "email_exists";
        }
        $stmt = $conn->prepare("INSERT INTO guest (fname, lname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fname, $lname, $email, $password);
        if ($stmt->execute()) {
            return "success";
        } else {
            return "error";
        }
    }
}
?>
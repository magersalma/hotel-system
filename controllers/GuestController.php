<?php
require_once '../config/db.php';
session_start();

class GuestController {

    public static function checkAccess() {
        if (!isset($_SESSION['role']) || 
            $_SESSION['role'] != "guest") {
            header("Location: ../views/index.html");
            exit();
        }
    }

    public static function index() {
        self::checkAccess();
        header("Location: ../views/guest.html");
        exit();
    }
}

GuestController::index();
?>
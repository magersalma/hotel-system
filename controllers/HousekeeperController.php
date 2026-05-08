<?php
require_once '../config/db.php';
session_start();

class HousekeeperController {

    public static function checkAccess() {
        if (!isset($_SESSION['role']) || 
            $_SESSION['role'] != "employee" || 
            $_SESSION['position'] != "housekeeper") {
            header("Location: ../views/index.html");
            exit();
        }
    }

    public static function index() {
        self::checkAccess();
        header("Location: ../views/housekeeper.html");
        exit();
    }
}

HousekeeperController::index();
?>
<?php
require_once '../config/db.php';
session_start();

class ManagerController {

    public static function checkAccess() {
        if (!isset($_SESSION['role']) || 
            $_SESSION['role'] != "employee" || 
            $_SESSION['position'] != "manager") {
            header("Location: ../views/index.html");
            exit();
        }
    }

    public static function index() {
        self::checkAccess();
        header("Location: ../views/manager.html");
        exit();
    }
}

ManagerController::index();
?>
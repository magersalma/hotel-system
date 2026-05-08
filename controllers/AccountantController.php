<?php
require_once '../config/db.php';
session_start();

class AccountantController {

    public static function checkAccess() {
        if (!isset($_SESSION['role']) || 
            $_SESSION['role'] != "employee" || 
            $_SESSION['position'] != "accountant") {
            header("Location: ../views/index.html");
            exit();
        }
    }

    public static function index() {
        self::checkAccess();
        header("Location: ../views/Accountant.html");
        exit();
    }
}

AccountantController::index();
?>
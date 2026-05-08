<?php
require_once '../config/db.php';
session_start();

class FrontDeskController {

    public static function checkAccess() {
        if (!isset($_SESSION['role']) || 
            $_SESSION['role'] != "employee" || 
            $_SESSION['position'] != "front_desk") {
            header("Location: ../views/index.html");
            exit();
        }
    }

    public static function index() {
        self::checkAccess();
        header("Location: ../views/frontdesk.html");
        exit();
    }
}

FrontDeskController::index();
?>
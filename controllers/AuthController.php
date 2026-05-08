<?php
require_once '../config/db.php';
require_once '../models/GuestModel.php';
require_once '../models/EmployeeModel.php';
session_start();

class AuthController {

    // =====================
    // LOGIN
    // =====================
    public static function login() {
        $email    = $_POST['email']    ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header("Location: ../views/index.html?error=missing_fields");
            exit();
        }

        // CHECK GUEST
        $user = GuestModel::getByEmail($email);

        if ($user) {
            if ($password == $user['password']) {
                $_SESSION['role'] = "guest";
                $_SESSION['id']   = $user['guest_num'];
                $_SESSION['name'] = $user['fname'];
                header("Location: GuestController.php");
                exit();
            } else {
                header("Location: ../views/index.html?error=wrong_password");
                exit();
            }
        }

        // CHECK EMPLOYEE
        $user = EmployeeModel::getByEmail($email);

        if ($user) {
            if ($password == $user['paasword']) {
                $_SESSION['role']     = "employee";
                $_SESSION['position'] = $user['position'];
                $_SESSION['id']       = $user['emp_id'];
                $_SESSION['name']     = $user['fname'];

                if ($user['position'] == "manager") {
                    header("Location: ManagerController.php");
                } elseif ($user['position'] == "housekeeper") {
                    header("Location: HousekeeperController.php");
                } elseif ($user['position'] == "front_desk") {
                    header("Location: FrontDeskController.php");
                } elseif ($user['position'] == "accountant") {
                    header("Location: AccountantController.php");
                } elseif ($user['position'] == "headman") {
                    header("Location: HeadmanController.php");
                } else {
                    header("Location: ../views/index.html?error=unknown_position");
                }
                exit();
            } else {
                header("Location: ../views/index.html?error=wrong_password");
                exit();
            }
        }

        // NOT FOUND
        header("Location: ../views/index.html?error=user_not_found");
        exit();
    }

    // =====================
    // SIGNUP
    // =====================
    public static function signup() {
        $fname    = $_POST['fname']            ?? '';
        $lname    = $_POST['lname']            ?? '';
        $email    = $_POST['email']            ?? '';
        $password = $_POST['password']         ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            header("Location: ../views/index.html?error=password_mismatch");
            exit();
        }

        $result = GuestModel::create($fname, $lname, $email, $password);

        if ($result == "email_exists") {
            header("Location: ../views/index.html?error=email_exists");
        } elseif ($result == "success") {
            header("Location: ../views/index.html?success=registered");
        } else {
            header("Location: ../views/index.html?error=server_error");
        }
        exit();
    }

    // =====================
    // LOGOUT
    // =====================
    public static function logout() {
        session_destroy();
        header("Location: ../views/index.html");
        exit();
    }
}

// =====================
// ROUTER
// =====================
$action = $_GET['action'] ?? '';

if ($action == "login") {
    AuthController::login();
} elseif ($action == "signup") {
    AuthController::signup();
} elseif ($action == "logout") {
    AuthController::logout();
}
?>
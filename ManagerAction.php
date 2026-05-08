<?php

require_once '../config/db.php';
require_once '../models/ManagerModel.php';

session_start();


//ACCESS CONTROL
if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != "employee" ||
    $_SESSION['position'] != "manager"
) {
    echo json_encode([
        "success" => false,
        "message" => "Access Denied"
    ]);
    exit();
}


$model = new ManagerModel($conn);


//ACTION ROUTER

$action = $_GET['action'] ?? '';

switch ($action) {

    
    //DASHBOARD STATS
    
    case 'stats':

        header('Content-Type: application/json');

        echo json_encode(
            $model->getDashboardStats()
        );

        break;


    //PENDING BOOKINGS
    
    case 'pendingBookings':

        header('Content-Type: application/json');

        echo json_encode(
            $model->getPendingBookings()
        );

        break;


    
    //ALL BOOKINGS
    
    case 'allBookings':

        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';

        header('Content-Type: application/json');

        echo json_encode(
            $model->getAllBookings($status, $search)
        );

        break;


    
    //APPROVE BOOKING
    
    case 'approveBooking':

        $id = $_POST['id'] ?? 0;

        $result = $model->approveBooking($id);

        header('Content-Type: application/json');

        echo json_encode([
            "success" => $result
        ]);

        break;


    
    //REJECT BOOKING
    
    case 'rejectBooking':

        $id = $_POST['id'] ?? 0;

        $result = $model->rejectBooking($id);

        header('Content-Type: application/json');

        echo json_encode([
            "success" => $result
        ]);

        break;


   
   // RECENT GUESTS
    
    case 'recentGuests':

        header('Content-Type: application/json');

        echo json_encode(
            $model->getRecentGuests()
        );

        break;


    
    //ALL GUESTS
    
    case 'allGuests':

        header('Content-Type: application/json');

        echo json_encode(
            $model->getAllGuests()
        );

        break;


    
    /*
    ========================================================
    ROOMS
    ========================================================
    */

    case 'rooms':

        header('Content-Type: application/json');

        echo json_encode(
            $model->getRooms()
        );

        break;


    
    //TOGGLE ROOM STATUS
    
    case 'toggleRoom':

        $id = $_POST['id'] ?? 0;

        $result = $model->toggleRoom($id);

        header('Content-Type: application/json');

        echo json_encode([
            "success" => $result
        ]);

        break;


    
    //DEFAULT
    
    default:

        header('Content-Type: application/json');

        echo json_encode([
            "success" => false,
            "message" => "Invalid Action"
        ]);

        break;
}

?>
<?php
header("Content-Type: application/json");
require_once "../models/ReservationModel.php";

$model = new ReservationModel();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "search") {
        $type  = $_POST["type"] ?? "";
        $rooms = $model->searchRooms("", "", $type);
        echo json_encode($rooms);
        exit;
    }
}

// GET request — return all rooms
$rooms = $model->searchRooms("", "", "");
echo json_encode($rooms);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {

    if ($_POST["action"] == "search") {
        $type  = $_POST["type"] ?? "";
        $rooms = $model->searchRooms("", "", $type);
        echo json_encode($rooms);
        exit;
    }

    // ← ADD THIS
    if ($_POST["action"] == "book") {
        $checkin  = new DateTime($_POST["checkin"]);
        $checkout = new DateTime($_POST["checkout"]);
        $nights   = $checkin->diff($checkout)->days;

        $data = [
            'fname'     => $_POST["firstname"],
            'lname'     => $_POST["lastname"],
            'email'     => $_POST["email"],
            'phone'     => $_POST["phone"],
            'room_num'  => $_POST["room_num"],
            'room_rate' => $_POST["room_rate"],
            'nights'    => $nights
        ];

        $res_id = $model->createBooking($data);

        if ($res_id) {
            echo json_encode(['success' => true, 'res_id' => $res_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Booking failed']);
        }
        exit;
    }
}
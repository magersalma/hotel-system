<?php

require_once "../config/db.php";

class ReservationModel {

    private $conn;

    public function __construct() {
        $database   = new Database();
        $this->conn = $database->connect();
    }

    public function searchRooms($checkin, $checkout, $type) {
        if (!empty($type)) {
            $sql  = "SELECT * FROM room WHERE type = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $type);
        } else {
            $sql  = "SELECT * FROM room";
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $rooms  = [];
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
        return $rooms;
    }

    public function createBooking($data) {
        $nights    = (int)   $data['nights'];
        $room_rate = (float) $data['room_rate'];
        $tax       = $room_rate * $nights * 0.14;
        $total     = $room_rate * $nights + $tax;

        // 1. Insert guest
        $stmt = $this->conn->prepare(
            "INSERT INTO guest (fname, lname, email, password, phone)
             VALUES (?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE guest_num=LAST_INSERT_ID(guest_num)"
        );
        $password = password_hash("temp1234", PASSWORD_DEFAULT);
        $stmt->bind_param("sssss",
            $data['fname'],
            $data['lname'],
            $data['email'],
            $password,
            $data['phone']
        );
        $stmt->execute();
        $guest_num = $this->conn->insert_id;

        // 2. Create invoice
        $stmt = $this->conn->prepare(
            "INSERT INTO invoice (guest_id, room_rate, total_price, hotel_taxes, status)
             VALUES (?, ?, ?, ?, 'pending')"
        );
        $stmt->bind_param("iddd", $guest_num, $room_rate, $total, $tax);
        $stmt->execute();
        $invoice_id = $this->conn->insert_id;

        // 3. Create reservation
        $stmt = $this->conn->prepare(
            "INSERT INTO reservation (date, state, guest_num, invoice_id, booking_state, first_name, `last_name`, phone_num)
             VALUES (CURDATE(), 'active', ?, ?, 'confirmed', ?, ?, ?)"
        );
        $stmt->bind_param("iissi",
            $guest_num,
            $invoice_id,
            $data['fname'],
            $data['lname'],
            $data['phone']
        );
        $stmt->execute();
        $res_id = $this->conn->insert_id;

        
        $stmt = $this->conn->prepare(
            "INSERT INTO include_room (room_num, res_id) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $data['room_num'], $res_id);
        $stmt->execute();

        return $res_id;
    }

}  
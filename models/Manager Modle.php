<?php

class ManagerModel
{
    private $conn;

    public function construct($database)
    {
        $this->conn = $database;
    }


    public function getDashboardStats()
    {
        $data = [];

        // Total bookings
        $q1 = mysqli_query(
            $this->conn,
            "SELECT COUNT(*) AS total FROM bookings"
        );

        $data['total'] =
            mysqli_fetch_assoc($q1)['total'];

        // Pending bookings
        $q2 = mysqli_query(
            $this->conn,
            "SELECT COUNT(*) AS total
             FROM bookings
             WHERE status='pending'"
        );

        $data['pending'] =
            mysqli_fetch_assoc($q2)['total'];

        // Confirmed bookings
        $q3 = mysqli_query(
            $this->conn,
            "SELECT COUNT(*) AS total
             FROM bookings
             WHERE status='confirmed'"
        );

        $data['confirmed'] =
            mysqli_fetch_assoc($q3)['total'];
    }

    public function getPendingBookings()
    {
        $sql = "
            SELECT
                id,
                guestName,
                roomName,
                checkIn,
                checkOut
            FROM bookings
            WHERE status='pending'
            ORDER BY id DESC
            LIMIT 5
        ";

        $result = mysqli_query($this->conn, $sql);

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    
    //ALL BOOKINGS

    public function getAllBookings($status = '', $search = '')
    {
        $sql = "
            SELECT *
            FROM bookings
            WHERE 1=1
        ";

        // Filter
        if ($status != '') {
            $sql .= " AND status='$status'";
        }

        // Search
        if ($search != '') {
            $sql .= "
                AND (
                    guestName LIKE '%$search%'
                    OR ref LIKE '%$search%'
                )
            ";
        }

        $sql .= " ORDER BY id DESC";

        $result = mysqli_query($this->conn, $sql);

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

   
   // APPROVE BOOKING
   
    public function approveBooking($id)
    {
        return mysqli_query(
            $this->conn,
            "UPDATE bookings
             SET status='confirmed'
             WHERE id='$id'"
        );
    }

    //REJECT BOOKING
    
    public function rejectBooking($id)
    {
        return mysqli_query(
            $this->conn,
            "UPDATE bookings
             SET status='cancelled'
             WHERE id='$id'"
        );
    }

    //ALL GUESTS
    
    public function getAllGuests()
    {
        $sql = "
            SELECT *
            FROM users
            WHERE role != 'manager'
        ";

        $result = mysqli_query($this->conn, $sql);

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
}
    
    //ROOMS
    
    public function getRooms()
    {
        $result = mysqli_query(
            $this->conn,
            "SELECT *
             FROM rooms"
        );

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    
    //TOGGLE ROOM STATUS
    
    public function toggleRoom($id)
    {
        return mysqli_query(
            $this->conn,
            "UPDATE rooms
             SET available = NOT available
             WHERE id='$id'"
        );
    }
}

?>

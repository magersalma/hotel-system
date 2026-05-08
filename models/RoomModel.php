<?php

require_once '../config/Database.php';

class RoomModel {
    private $db;

    public function __construct() {
    
        $this->db = Database::getInstance()->getConnection();
    }

    
    public function getAllRooms() {
        $query = "SELECT * FROM room";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function updateStatus($roomNum, $cleaningStatus) {
    
    $roomState = ($cleaningStatus == 'cleaning' || $cleaningStatus == 'needs-cleaning') ? 'unavailable' : 'available';
    
    $sql = "UPDATE room SET 
            cleaning_state = '$cleaningStatus', 
            room_state = '$roomState' 
            WHERE room_num = '$roomNum'";
            
    return mysqli_query($this->db, $sql);
}
    

    
}
?>
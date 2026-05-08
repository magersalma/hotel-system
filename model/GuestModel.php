<?php
require_once '../Database.php';
class GuestModel {
    private $db;  

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    //function 1 : view profile
    public function getProfileData($guestId) {
         $sql = "SELECT * FROM guest WHERE guest_num = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bind_param("i", $guestId);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    //function 2:update profile
    public function updateProfileData($guestId, $fname, $lname, $email) {
        $sql = "UPDATE guest SET fname = ?, lname = ?, email = ? WHERE guest_num = ?";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bind_param("sssi", $fname, $lname, $email, $guestId);
        
        if ($stmt->execute()) {
            return true;  
        } else {
            return false;  
        }
    }
    //function 3:booking
    public function getGuestBookings($guestID) {
    $sql = "SELECT r.*, rm.type, rm.price 
            FROM reservation r 
            JOIN include_room ir ON r.res_id = ir.res_id
            JOIN room rm ON ir.room_num = rm.room_num 
            WHERE r.guest_num = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $guestID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    return $bookings;
}
    //function 4:feedback
public function addFeedback($resID, $rating, $comment) {
    $sql = "INSERT INTO feedback (res_id, rating, comment) VALUES (?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("iis", $resID, $rating, $comment);
    return $stmt->execute();
}
}
?>
<?php
require_once '../model/GuestModel.php';

class GuestController {
    //function 1
    public function showProfile($id) {
        $model = new GuestModel();
        
        $data = $model->getProfileData($id);
        
        return $data;
    }

    //function 2
    public function updateProfile($id, $fname, $lname, $email) {
        $model = new GuestModel();
        
        $result = $model->updateProfileData($id, $fname, $lname, $email);
        
        return $result;
    }
    //function 3
    public function showBookings($guestID) {
    $model = new GuestModel();
    return $model->getGuestBookings($guestID);
}

    //function 4
public function submitFeedback($resID, $rating, $comment) {
    $model = new GuestModel();
    return $model->addFeedback($resID, $rating, $comment);
}
}
?>
<?php

$root = "D:/xampp/htdocs/hotel-system";

require_once $_SERVER['DOCUMENT_ROOT'] . '/hotel-system/models/RoomModel.php';

class RoomController {
    private $model;
    public function __construct() {
        $this->model = new RoomModel();
    }
    public function getRooms() {
        return $this->model->getAllRooms();
    }
    public function changeStatus($roomNum, $newStatus) {
    
        return $this->model->updateStatus($roomNum, $newStatus);
    }
    public function changeRepairStatus($roomNum, $newRepairStatus) {
        return $this->model->updateRepairStatus($roomNum, $newRepairStatus);
}
}
?>
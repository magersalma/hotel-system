<?php
// بننادي على الـ Model عشان نطلب منه البيانات
require_once __DIR__ . '/../models/RoomModel.php';

class RoomController {
    private $model;

    public function __construct() {
        $this->model = new RoomModel();
    }

    // وظيفة بتطلب الأوض من الموديل وبترجعها لينا
    public function getRooms() {
        return $this->model->getAllRooms();
    }
}
?>
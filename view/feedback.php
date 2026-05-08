<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../controller/GuestController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new GuestController();
    $result = $controller->submitFeedback($_POST['res_id'], $_POST['rating'], $_POST['comment']);
    
    if($result) {
        echo "Feedback saved successfully!";
    } else {
        echo "An error occurred while saving your feedback.";
    }
}
?>
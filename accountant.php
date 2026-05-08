<?php
require_once '../Controllers/dbcontroller.php';

class Accountant
{
  private $acc_id;

  public function __construct($acc_id)
  {
    $this->acc_id = $acc_id;
  }

  public function validateAccountant()
  {
    if ($this->acc_id <= 0) {
      return false;
    }

    $db = new DBController();
    $connection = $db->openConnection();

    $stmt = $connection->prepare(
      "SELECT acc_id FROM accountant WHERE acc_id = ?");

    $stmt->bind_param("i", $this->acc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $db->closeConnection();

    return $result->num_rows > 0;
  }
}

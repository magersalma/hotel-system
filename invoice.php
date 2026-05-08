<?php
require_once '../Controllers/dbcontroller.php';

class Invoice
{
  private $guest_id;
  private $room_rate;
  private $total_service_price;
  private $total_price;
  private $acc_id;
  private $hotel_taxes;
  private $city_taxes;
  private $status;

  public function __construct($guest_id,$room_rate,$total_service_price,
    $acc_id,$status = 'Pending') 
  {
    $this->guest_id = $guest_id;
    $this->room_rate = $room_rate;
    $this->total_service_price = $total_service_price;
    $this->acc_id = $acc_id;
    $this->hotel_taxes = ($this->room_rate + $this->total_service_price) * 0.14;
    $this->city_taxes = ($this->room_rate + $this->total_service_price) * 0.05;

    $this->total_price = $this->room_rate + $this->total_service_price +
      $this->hotel_taxes + $this->city_taxes;
      
    $this->status = $status;
  }

  public function createInvoice()
  {
    if ($this->guest_id <= 0 || $this->acc_id <= 0) {
      return false;
    }

    $db = new DBController();
    $connection = $db->openConnection();

    $stmt = $connection->prepare(
      "INSERT INTO invoice(guest_id,room_rate,total_service_price,total_price,
              acc_id,hotel_taxes,city_taxes,status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("idddiids",$this->guest_id,$this->room_rate,
      $this->total_service_price,$this->total_price,$this->acc_id,
      $this->hotel_taxes,$this->city_taxes,$this->status);

    $result = $stmt->execute();
    $invoice_id = $connection->insert_id;
    $stmt->close();
    $db->closeConnection();

    return $result ? $invoice_id : false;
  }
}

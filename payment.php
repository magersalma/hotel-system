<?php
require_once '../Controllers/dbcontroller.php';

class Payment
{
    private $trans_num;
    private $card_id;
    private $method;
    private $latePenalty;
    private $invoice_id;

    public function __construct($card_id, $method, $latePenalty, $invoice_id)
    {
        $this->card_id = $card_id;
        $this->method = $method;
        $this->latePenalty = $latePenalty;
        $this->invoice_id = $invoice_id;
    }

    public function createPayment()
    {
        if (empty($this->method) || $this->invoice_id <= 0) {
            return false;
        }

        $db = new DBController();
        $connection = $db->openConnection();

        $stmt = $connection->prepare(
            "INSERT INTO payment(card_id, method, latePenalty, invoice_id)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param("ssdi",$this->card_id,$this->method,$this->latePenalty,
            $this->invoice_id);

        $result = $stmt->execute();
        $stmt->close();
        $db->closeConnection();

        return $result;
    }
}

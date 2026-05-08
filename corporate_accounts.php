<?php
require_once '../Controllers/dbcontroller.php';

class CorporateAccounts
{

  private $corporate_id;
  private $company_name;
  private $accountant_id;

  public function __construct($company_name, $accountant_id)
  {
    $this->company_name = $company_name;
    $this->accountant_id = $accountant_id;
  }

  public function createCorporateAccount()
  {
    if (empty($this->company_name) || $this->accountant_id <= 0) {
      return false;
    }

    $db = new DBController();
    $connection = $db->openConnection();

    $stmt = $connection->prepare(
      "INSERT INTO corporate_accounts (company_name, accountant_id)
             VALUES (?, ?)"
    );

    $stmt->bind_param("si", $this->company_name, $this->accountant_id);

    $result = $stmt->execute();
    $stmt->close();
    $db->closeConnection();
    return $result;
  }

  public function getCorporateAccount($id)
  {
    $db = new DBController();
    $connection = $db->openConnection();
    
    $stmt = $connection->prepare(
      "SELECT * FROM corporate_accounts WHERE corporate_id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $db->closeConnection();
    return $result;
  }
}

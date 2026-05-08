<?php
class DBController
{
  private $dbHost="localhost";
  private $dbUser="root";
  private $dbPassword="";
  private $dbName="hotelsystem";
  private $connection;
  public function openConnection()
  {
    $this->connection = new mysqli($this->dbHost,$this->dbUser,$this->dbPassword,$this->dbName);
    if($this->connection->connect_error)
    {
      echo "Connection Error : " . $this->connection->connect_error;
      return false;
    }
    else
    {
      return $this->connection;
    }
  }

  public function closeConnection()
  {
    if($this->connection)
    {
      $this->connection->close();
    }
    else
    {
      echo "Connection is already closed";
    }
  }
  public function select($query)
  {
    $result = $this->connection->query($query);
    if(!$result)
    {
      echo "Error : " . mysqli_error($this->connection);
      return false;
    }
    else
    {
      return $result->fetch_all(MYSQLI_ASSOC);
    }
  }
}

?>
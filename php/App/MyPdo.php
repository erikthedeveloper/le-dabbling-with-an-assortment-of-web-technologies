<?php
namespace App;

use PDO;

class MyPdo {

  /**
   * @var PDO
   */
  public $pdo;

  public function __construct($host, $user, $password, $database, $port = 3306)
  {
    $dsn = "mysql:host={$host};dbname={$database};port={$port}";
    $pdo = new PDO($dsn, $user, $password);
    $this->pdo = $pdo;
  }

  public function executeStatement($sql, array $data = [])
  {
    $statement = $this->pdo->prepare($sql);
    $success = $statement->execute($data);
    return $success;
  }

  public function retrieveStatement($sql, array $data = [])
  {
    $statement = $this->pdo->prepare($sql);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute($data);
    return $statement;
  }

}

/* Example usages...

- - Insert
$DB->executeStatement("INSERT INTO people (first_name, last_name) VALUES (?, ?)", ["Joe", "Schmoe"]);
- - Update
$DB->executeStatement("UPDATE people SET first_name = ? WHERE id = ?", ["Joe", 15]);
- - Delete
$DB->executeStatement("DELETE FROM people WHERE first_name = ? OR last_name = ?", ["Joe", "Schmoe"]);

- - Retrieve All
$statement = $DB->retrieveStatement("SELECT * FROM people ORDER BY id DESC");
$people = $statement->fetchAll();

- - Retrieve One
$statement = $DB->retrieveStatement("SELECT * FROM people ORDER BY id DESC");
$person = $statement->fetch();
*/
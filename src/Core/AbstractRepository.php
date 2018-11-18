<?php
namespace App\Core;

use PDO;

abstract class AbstractRepository
{

  protected $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  abstract public function getTableName();

  abstract public function getModelName();

  function query($qry)
  {
	  $table = $this->getTableName();
	  $model = $this->getModelName();
	  $stmt = $this->pdo->prepare($qry);
	  $req = $stmt->execute();
	  return $req;
  }

  function all()
  {
     $table = $this->getTableName();
     $model = $this->getModelName();
     $stmt = $this->pdo->query("SELECT * FROM `$table`");
     $res = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
     return $res;
  }

  function find($id)
  {
    $table = $this->getTableName();
    $model = $this->getModelName();
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $res = $stmt->fetch(PDO::FETCH_CLASS);

    return $res;
  }
}
 ?>

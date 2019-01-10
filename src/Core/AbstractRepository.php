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

  public function select($query, $rows="*")
  {
    $table = $this->getTableName();
    $model = $this->getModelName();


    #Prepare parameters
    $conditions = explode(" AND ", $query);
    $cRow = [];
    $cPam = [];

    foreach($conditions as $condition) {
      $condition = explode("=", $condition);
      $crow[] = $condition[0];
      $cpam[] = $condition[1];
    }

    foreach ($crow as $key => $value) {
      if ($key > 0) {
        $parameters .= " AND ";
      }
      $parameters .= "{$value} = :{$value}";
    }

    $args = [];
    foreach ($cpam as $key => $value) {
      $args[$crow[$key]] = $value;
    }

    $stmt = $this->pdo->prepare("SELECT {$rows} FROM `$table` WHERE {$parameters}");
    $stmt->execute($args);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $res = $stmt->fetch(PDO::FETCH_CLASS);  }
}

select("username=fiona AND password=test");
 ?>

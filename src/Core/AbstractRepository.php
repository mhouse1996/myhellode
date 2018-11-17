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

  function qry($arg1, $param1, $arg2=null, $param2=null, $arg3=null, $param3=null)
  {
    $table = $this->getTableName();
    $model = $this->getModelName();
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE :arg1 = :param1 AND :arg2 = :param2 AND :arg3 = :param3");
    $stmt = $stmt->execute(['arg1' => $arg1,
                            'param1' => $param1,
                            'arg2' => $arg2,
                            'param2' => $param2,
                            '$arg3' => $arg3,
                            '$param3' => $param3]);

  }

  /*function query($query)
  {
    $qry = explode("=", $query);
    $i=1;
    foreach($qry AS $qryArgs)
    {
      if($i == 1){
        $arg[]=$qryArgs;
        $argCounter++;
        $i++;
      }elseif ($i == 2) {
        $param[]=$qryArgs;
        $i=1;
      }
    }
    for($i=1, $i <= $argCounter, $i++)
    {
      $qry.=":".$arg[$i]." = :".$param[$i];
      if($i>1){
        $arg .= " AND ";
      }
    }
    $table = $this->getTableName();
    $model = $this->getModelName();
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE :arg1 = :param1 AND :arg2 = :param2 AND :arg3 = :param3");
    $stmt = $stmt->execute(['arg1' => $arg1,
                            'param1' => $param1,
                            'arg2' => $arg2,
                            'param2' => $param2,
                            '$arg3' => $arg3,
                            '$param3' => $param3]);
  }*/
  
  function query($qry)
  {
	  $table = $this->getTableName();
	  $model = $this->getModelName();
	  $stmt = $this->pdo->prepare($qry);
	  $stmt = $stmt->execute();
	  return $stmt;
  }

  function all()
  {
     $table = $this->getTableName();
     $model = $this->getModelName();
     $stmt = $this->pdo->query("SELECT * FROM `$table`");
     $result = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
     return $result;
  }

  function find($id)
  {
    $table = $this->getTableName();
    $model = $this->getModelName();
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $post = $stmt->fetch(PDO::FETCH_CLASS);

    return $post;
  }
}
 ?>

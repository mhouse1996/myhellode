<?php
namespace App\User;

use App\Core\AbstractRepository;
use PDO;

class UserRepository extends AbstractRepository
{

  public function getTableName()
  {
    return "accounts";
  }

  public function getModelName()
  {
    return "App\\User\\UserModel";
  }

  public function findByUsername($username)
  {
    $table = $this->getTableName();
    $model = $this->getModelName();
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $user = $stmt->fetch(PDO::FETCH_CLASS);
    return $user;
  }

  public function fetchUserById($id)
  {
    $table = $this->getTableName();
    $model = $this->getModelName();
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $user = $stmt->fetch(PDO::FETCH_CLASS);
    return $user;
  }

  public function searchUser($keyword)
  {
    $table = $this->getTableName();
    $model = $this->getModelName();
    /*$stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE username LIKE '%:keyword%' OR fullname LIKE '%:keyword%' OR email LIKE '%:keyword%'");
    $stmt->execute(['keyword' => $keyword]);*/
    $query = "SELECT * FROM `$table` WHERE fullname LIKE '%{$keyword}%'";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $users = $stmt->fetch(PDO::FETCH_CLASS);
    return $users;
  }

  /*public function fetchNavbar($user)
  {
    $table = "navbar";
    $model = "App\\User\NavigationModel";
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE securityLevel = :secLevel");
    $stmt->execute(['secLevel' => $user->grants]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $res = $stmt->fetch(PDO::FETCH_CLASS);
    return $res;
  }*/

}

?>

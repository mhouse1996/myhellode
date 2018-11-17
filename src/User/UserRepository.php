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

  public function fetchNavbar($user)
  {
    $table = "navbar";
    $model = "App\\User\NavigationModel";
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE securityLevel = :secLevel");
    $stmt->execute(['secLevel' => $user->grants]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
    $res = $stmt->fetch(PDO::FETCH_CLASS);
    return $res;
  }

}

?>

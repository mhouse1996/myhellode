<?php

namespace App\Log;

use App\Core\AbstractRepository;
use PDO;

class LogRepository extends AbstractRepository
{

    public function getTableName()
    {
        return "logs";
    }

    public function getModelName()
    {
        return "App\\Log\\LogModel";
    }

    public function queryLog($time, $controller, $msgtype, $msg, $user, $msgcode)
    {
      $table = $this->getTableName();
      $stmt = $this->pdo->prepare("INSERT INTO `$table` (time, controller, msgtype, msg, user, msgcode) VALUES (:time, :controller, :msgtype, :msg, :user, :msgcode)");
      $res = $stmt->execute(['time' => $time, 'controller' => $controller, 'msgtype' => $msgtype, 'msg' => $msg, 'user' => $user, 'msgcode' => $msgcode]);
      return $res;
    }

    public function fetchLogsByMsgType($msgType)
    {
      $table = $this->getTableName();
      $model = $this->getModelName();
      $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE msgcode = :msgtype");
      $stmt->execute(['msgtype' => $msgType]);
      $res = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
      return $res;
    }

    public function fetchLogsByUserId($userID)
    {
      $table = $this->getTableName();
      $model = $this->getModelName();
      $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE user = :userid");
      $stmt->execute(['userid' => $userID]);
      $res = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
      return $res;
    }

    public function fetchLastBreakByUserId($userID)
    {
      $table = $this->getTableName();
      $model = $this->getModelName();
      $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE user = :userid AND msgcode = 1 ORDER BY time DESC LIMIT 1");
      $stmt->execute(['userid' => $userID]);
      $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
      $res = $stmt->fetch(PDO::FETCH_CLASS);
      return $res;
    }

}

?>

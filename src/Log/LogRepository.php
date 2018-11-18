<?php

namespace App\Log;

use App\Core\AbstractRepository;

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

}

?>

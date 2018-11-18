<?php

namespace App\Log;

use App\Core\AbstractController;

class LogController
{

    public function __construct(LogRepository $logRepository)
    {
      $this->logRepository = $logRepository;
    }

    public function log($controller, $msgtype, $msg, $user=null)
    {
      return $this->logRepository->queryLog(time(), $controller, $msgtype, $msg, $user);
    }

    public function showlogs($type = "all")
    {

    }

}

?>

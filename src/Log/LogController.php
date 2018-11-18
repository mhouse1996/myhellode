<?php

namespace App\Log;

use App\Core\AbstractController;
use App\User\UserController;

class LogController extends AbstractController
{

    public function __construct(LogRepository $logRepository, UserController $userController, $configs)
    {
      $this->logRepository = $logRepository;
      $this->userController = $userController;
      $this->configs = $configs;
    }

    public function log($controller, $msgtype, $msg, $user=null)
    {
      return $this->logRepository->queryLog(time(), $controller, $msgtype, $msg, $user);
    }

    public function showlogs($type = "all")
    {
      if($this->userController->returnGrants() < $this->configs['logs']['adminSysGrantlevel']){
        header("Location: index");
      }
      $logs = $this->logRepository->all();
      $this->render('logs/showlogs', [
      'logs' => $logs]);
    }

}

?>

<?php

namespace App\Log;

use App\Core\AbstractController;
use App\User\UserController;

class LogController extends AbstractController
{
    private $controller;

    public function __construct(LogRepository $logRepository, UserController $userController, $configs)
    {
      $this->logRepository = $logRepository;
      $this->userController = $userController;
      $this->configs = $configs;
    }

    public function setController($controller)
    {
      $this->controller = $controller;
    }

    public function log($msgtype, $msg, $user=null, $msgcode=null)
    {
      return $this->logRepository->queryLog(time(), $this->controller, $msgtype, $msg, $user, $msgcode);
    }

    public function showlogs($type = "all")
    {
      if($this->userController->returnGrants() < $this->configs['logs']['adminSysGrantlevel']){
        header("Location: index");
      }
      $logs = $this->logRepository->all();
      $this->render('admin/logs/showlogs', [
      'logs' => $logs]);
    }

}

?>

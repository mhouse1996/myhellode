<?php

namespace App\Log;

use App\Core\AbstractController;
use App\User\UserService;

class LogController extends AbstractController
{
    private $controller;

    public function __construct(LogRepository $logRepository, UserService $userService, $configs)
    {
      $this->logRepository = $logRepository;
      $this->userService = $userService;
      $this->configs = $configs;
    }

    public function checkGrants()
    {
      if($this->userService->returnGrants() < $this->configs['logs']['adminSysGrantlevel']){
        header("Location: index");
      }
    }

    public function setController($controller)
    {
      $this->controller = $controller;
    }

    public function log($msgtype, $msg, $user=null, $msgcode=null)
    {
      return $this->logRepository->queryLog(time(), $this->controller, $msgtype, $msg, $user, $msgcode);
    }

    public function showLogs()
    {
      $this->checkGrants();
      if(isset($_GET['msgtype']) && !empty($_GET['msgtype'])){
          $msgType = $_GET['msgtype'];
          $logs = $this->logRepository->fetchLogsByMsgType($msgType);
      } else {
          $logs = $this->logRepository->all();
      }
      $this->render('admin/logs/showlogs', [
      'logs' => $logs]);
    }

    public function returnLogsByUserId($userID)
    {
      $this->checkGrants();
      $logs = $this->logRepository->fetchLogsByUserId($userID);
      return $logs;
    }

    public function returnLogsByMsgType($msgType)
    {
      return $this->logRepository->fetchLogsByMsgType($msgType);
    }

    public function returnLastBreakByUserId($userID)
    {
      return $this->logRepository->fetchLastBreakByUserId($userID);
    }

}

?>

<?php

namespace App\Log;

use App\Log\LogController;
use App\Log\LogRepository;

class LogService
{

  public function __construct(LogController $logController, LogRepository $logRepository)
  {
    $this->logController = $logController;
    $this->logRepository = $logRepository;
  }

  public function returnLogsByMsgType($msgType)
  {
    return $this->logRepository->returnLogsByMsgType($msgType);
  }

}

?>

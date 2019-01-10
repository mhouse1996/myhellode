<?php

namespace App\BreakSystem;

use App\Core\AbstractController;
use App\Log\LogController;
use App\User\UserService;

class BreakAdminController extends AbstractController
{

    public function __construct(BreakController $breakController, UserService $userService, LogController $logController)
    {
      $this->breakController = $breakController;
      $this->userService = $userService;
      $this->breakRepository = $breakController->breakRepository;
      $this->logController = $logController;
      $this->configs = $breakController->configs;

      $this->logController->setController("BreakAdminController");

      if($this->userService->returnGrants() < $this->configs['breakSystem']['adminSysGrantlevel']){
        header("Location: index");
      }
    }


    public function showAdminPage($err = 0)
    {
      $breakTickets = $this->breakController->fetchBreakTickets();

      $inboundFreeTicketCount = 0;
      $inboundUsedTicketCount = 0;
      $outboundFreeTicketCount = 0;
      $outboundUsedTicketCount = 0;

      foreach($breakTickets as $breakTicket)
      {
        if($breakTicket->activity == 1){
          if($breakTicket->userType == "service"){
            if($breakTicket->owner == null && $this->breakController->checkAvailabilityByTime($breakTicket)){
              $inboundFreeTicketCount++;
            } elseif($this->breakController->checkAvailabilityByTime($breakTicket)) {
              $inboundUsedTicketCount++;
            }
          } elseif($breakTicket->userType == "sales" && $this->breakController->checkAvailabilityByTime($breakTicket)) {
            if($breakTicket->owner == null){
              $outboundFreeTicketCount++;
            } elseif($this->breakController->checkAvailabilityByTime($breakTicket)) {
              $outboundUsedTicketCount++;
            }
          }
        }
      }

      $this->render('admin/breaksystem/admin', [
        'breakTickets' => $breakTickets,
        'inboundUsedTicketCount' => $inboundUsedTicketCount,
        'inboundFreeTicketCount' => $inboundFreeTicketCount,
        'outboundUsedTicketCount' => $outboundUsedTicketCount,
        'outboundFreeTicketCount' => $outboundFreeTicketCount,
        'userService' => $this->userService,
        'err' => $err
      ]);
    }

    public function addTicket()
    {
      if(isset($_POST['submit'])){
        $count = $_POST['count'];
        $userType = $_POST['userType'];
        $beginningTime = $_POST['beginningTime'];
        $endingTime = $_POST['endingTime'];

        for($i=0; $i < $count; $i++){
          $res = $this->breakRepository->addBreakTicket($userType, $beginningTime, $endingTime);
          $err = $res ? 0 : 1;
        }
      }
      $this->showAdminPage();
    }

    public function changeTicket()
    {
      if(isset($_GET['id']) && isset($_GET['action'])){
        $ticketID = $_GET['id'];
        $errmsg = "msgunset";

        if($_GET['action'] == "remove"){
          $req = $this->breakRepository->removeBreakTicket($ticketID);
          $errmsg = 'couldNotRemoveTicket';
        } elseif($_GET['action'] == "toggle" && isset($_GET['state'])) {
          $req = $this->breakRepository->toggleActivityState($ticketID, $_GET['state']);
          $errmsg = 'couldNotToggleTicket';
        } elseif ($_GET['action'] == "release") {
          $req = $this->breakRepository->unbreakByTicketId($ticketID);
          $this->logController->log("INFO", "User {$_SESSION['username']}({$_SESSION['fullname']}) released break ticket {$ticketID}", $_SESSION['id']);
        }

        if($req){
          $this->showAdminPage();
        } else {
          $this->render("breakSystem/error", [
            'msg' => $errmsg
          ]);
        }
      }
    }


}

?>

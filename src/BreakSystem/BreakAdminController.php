<?php

namespace App\BreakSystem;

use App\Core\AbstractController;
use App\Log\LogController;

class BreakAdminController extends AbstractController
{

    public function __construct(BreakController $breakController, LogController $logController)
    {
      $this->breakController = $breakController;
      $this->userController = $breakController->userController;
      $this->breakRepository = $breakController->breakRepository;
      $this->logController = $logController;
      $this->configs = $breakController->configs;

      $this->logController->setController("BreakAdminController");

      if($this->userController->returnGrants() < $this->configs['breakSystem']['adminSysGrantlevel']){
        header("Location: index");
      }
    }


    public function showAdminPage($err = 0)
    {
      
      $this->render('admin/breaksystem/admin', [
        'breakTickets' => $this->breakController->fetchBreakTickets(),
        'breakController' => $this->breakController,
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

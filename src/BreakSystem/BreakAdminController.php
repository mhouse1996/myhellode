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

      if($this->userController->returnGrants() < $this->configs['breakSystem']['adminSysGrantlevel']){
        header("Location: index");
      }
    }


    public function showAdminPage($err = 0)
    {
      $this->render('breaksystem/admin', [
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

    public function removeTicket()
    {
      if(isset($_GET['id'])){
        $ticketID = $_GET['id'];
        $req = $this->breakRepository->removeBreakTicket($ticketID);

        if($req){
          $this->showAdminPage();
        } else {
          $this->logController->log('BreakAdminController', 'ERR', 'Could not remove ticket');
          $this->render("breakSystem/error", [
            'msg' => 'couldNotRemoveTicket'
          ]);
        }
      }
    }


}

?>

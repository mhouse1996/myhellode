<?php

namespace App\BreakSystem;

use App\Core\AbstractController;

class BreakAdminController extends AbstractController
{

    public function __construct(BreakController $breakController)
    {
      $this->breakController = $breakController;
      $this->userController = $breakController->userController;
      $this->breakRepository = $breakController->breakRepository;
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
      $count = $_POST['count'];
      $userType = $_POST['userType'];
      $beginningTime = $_POST['beginningTime'];
      $endingTime = $_POST['endingTime'];

      for($i=0; $i < $count; $i++){
        $res = $this->breakRepository->addBreakTicket($userType, $beginningTime, $endingTime);
        $err = $res ? 0 : 1;
      }
      $this->showAdminPage();
    }



}

?>

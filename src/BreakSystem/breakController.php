<?php

namespace App\BreakSystem;

use App\Core\AbstractController;
use App\User\UserController;

class breakController extends AbstractController
{

  public function __construct(UserController $userController,
  BreakRepository $breakRepository, $configs)
  {
    $this->userController = $userController;
    $this->breakRepository = $breakRepository;
    $this->configs = $configs;

    if(!$this->userController->checkLoginstate()){
      header("Location: index");
    }
  }

  public function fetchBreakTickets()
  {
    $breakTickets = array();
    $breakTickets = $this->breakRepository->all();
    return $breakTickets;
  }

  public function checkTickets()
  {

  }

  public function getFreeBreakTickets()
  {
    $freeBreakTickets = array();
    $breakTickets = array();

    $breakTickets = $this->fetchBreakTickets();
    $breakTicketsSubstr = 0;

    if(!empty($breakTickets))
    {
      foreach($breakTickets AS $breakTicket)
      {
        //Check if someone forget to give his breakticket free
        if($breakTicket->timeToken != null AND (time()-$breakTicket->timeToken) > ($this->configs['breakSystem']['latencyTime']*60)) {
          die("1");
          //log("User did not unbreak", $_SESSION['id'], time());
          $this->breakRepository->unbreak($breakTicket->owner);
          $breakTicket->timeToken = null;
          $breakTicket->owner = null;
        }

        //Check if breakticket of earlier time period is still token
        if(!$this->checkAvailabilityByTime($breakTicket) AND $breakTicket->userType == $_SESSION['usertype'] AND isset($breakTicket->owner)) {
          echo("Owner:".$breakTicket->owner."\n");
          $breakTicketsSubstr++;
        }
        echo "Substrator: ".$breakTicketsSubstr."\n";
        //Check if ticket is available at this time
        if($this->checkAvailability($breakTicket)) {
          echo "Ticket is available\n";
          if($breakTicketsSubstr>0) {
            echo "Downgraded.\n";
            $breakTicketsSubstr = $breakTicketsSubstr-1;
          }else {
            $freeBreakTickets[] = $breakTicket;
          }
        }
        echo "FIN\n";
      }
    }

    return $freeBreakTickets;
  }

  public function checkAvailability($breakTicket)
  {
    if($breakTicket->userType == $_SESSION['usertype'] AND !isset($breakTicket->owner)){
      if($this->checkAvailabilityByTime($breakTicket)){
        return true;
      } else {
        return false;
      }
    }
  }

  public function checkAvailabilityByTime($breakTicket)
  {
    $timeNow = date("H:i");
    if($timeNow > $breakTicket->beginningTime AND $timeNow < $breakTicket->endingTime) {
      return true;
    }else {
      return false;
    }
  }

  public function showFreeBreakTickets()
  {
    if($this->checkIfUserIsInBreak()){
      $this->render('breaksystem/showtickets', [
        'msg' => 'userAlreadyInBreak',
        'freeBreakTickets' => 0
      ]);
    }else{
      $freeBreakTickets = $this->getFreeBreakTickets();

      $this->render('breaksystem/showtickets', [
        'freeBreakTickets' => $freeBreakTickets
      ]);
    }
  }

  public function fetchBreakTicketById($ticketID)
  {
    $breakTicket = $this->breakRepository->find($ticketID);
    return $breakTicket;
  }

  public function takeBreakTicket()
  {
    $ticketID = $_GET['id'];
    $ticket = $this->breakRepository->find($ticketID);

    if(!isset($ticket->owner) AND $ticket->userType == $_SESSION['usertype'] AND $this->checkAvailability($this->fetchBreakTicketById($ticketID)) AND isset($_POST['estimatedBreakDuration'])){
      if($this->breakRepository->takeBreakTicket($ticketID, $_SESSION['id'], $_POST['estimatedBreakDuration'])){
        header("Location: breaksystem");
      }else {
        $this->render("breakSystem/error", [
          'msg' => 'couldNotTakeBreakticket'
        ]);
      }
    }else {
      $this->render("breakSystem/error", [
        'msg' => 'breakTicketNotAvailable'
      ]);
    }
  }

  public function checkIfUserIsInBreak()
  {
    $breakTickets = $this->fetchBreakTickets();

    foreach($breakTickets AS $breakTicket)
    {
      if($breakTicket->owner == $_SESSION['id']){
        return true;
      }
    }
  }

  public function unbreak()
  {
    $req = $this->breakRepository->unbreak($_SESSION['id']);

    if($req){
      header("Location: breaksystem");
    }else{
      $this->render("breakSystem/error", [
        'msg' => 'couldNotUnbreak'
      ]);
    }
  }


}


?>

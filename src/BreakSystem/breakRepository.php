<?php

namespace App\BreakSystem;

use App\Core\AbstractRepository;

class BreakRepository extends AbstractRepository
{
  public function getTableName()
  {
    return "breakTickets";
  }

  public function getModelName()
  {
    return "App\\BreakSystem\\BreakModel";
  }

  public function takeBreakTicket($ticketID, $userID, $estimatedBreakDuration)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("UPDATE `$table` SET owner = :owner , timeToken = :timeToken , estimatedBreakDuration = :estimatedBreakDuration WHERE id = :id");
    $req = $stmt->execute(['owner' => $userID, 'timeToken' => time(), 'estimatedBreakDuration' => $estimatedBreakDuration, 'id' => $ticketID]);
    return $req;
  }

  public function unbreak($userID)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("UPDATE `$table` SET owner = null , timeToken = null , estimatedBreakDuration = null WHERE owner = :userID");
    $req = $stmt->execute(['userID' => $userID]);
    return $req;
  }

  public function addBreakTicket($userType, $beginningTime, $endingTime)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("INSERT INTO `$table` (userType, beginningTime, endingTime) VALUES (:userType, :beginningTime, :endingTime)");
    $req = $stmt->execute(['userType' => $userType,
                            'beginningTime' => $beginningTime,
                            'endingTime' => $endingTime]);
    return $req;
  }

  public function removeBreakTicket($ticketID)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("DELETE FROM `$table` WHERE id=:id");
    $req = $stmt->execute(['id' => $ticketID]);
    return $req;
  }

  public function toggleActivityState($ticketID, $activityState)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("UPDATE `$table` SET activity = :state WHERE id = :id");
    $req = $stmt->execute(['state' => $activityState, 'id' => $ticketID]);
    return $req;
  }
}
?>

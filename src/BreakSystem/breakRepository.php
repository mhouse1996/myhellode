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
    $res = $stmt->execute(['owner' => $userID, 'timeToken' => time(), 'estimatedBreakDuration' => $estimatedBreakDuration, 'id' => $ticketID]);
    return $res;
  }

  public function unbreak($userID)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("UPDATE `$table` SET owner = null , timeToken = null , estimatedBreakDuration = null WHERE owner = :userID");
    $res = $stmt->execute(['userID' => $userID]);
    return $res;
  }

  public function addBreakTicket($userType, $beginningTime, $endingTime)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("INSERT INTO `$table` (userType, beginningTime, endingTime) VALUES (:userType, :beginningTime, :endingTime)");
    $res = $stmt->execute(['userType' => $userType,
                            'beginningTime' => $beginningTime,
                            'endingTime' => $endingTime]);
    return $res;
  }

  public function removeBreakTicket($ticketID)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("DELETE FROM `$table` WHERE id=:id");
    $res = $stmt->execute(['id' => $ticketID]);
    return $res;
  }
}
?>

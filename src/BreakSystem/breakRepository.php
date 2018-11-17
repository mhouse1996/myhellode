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
}
?>

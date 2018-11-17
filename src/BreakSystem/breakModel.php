<?php

namespace App\Breaksystem;

use App\Core\AbstractModel;

class BreakModel extends AbstractModel
{
  public $id;
  public $owner;
  public $timeToken;
//  public $ticketType;
  public $userType;
  public $beginningTime;
  public $endingTime;
  public $estimatedBreakDuration;
}

?>

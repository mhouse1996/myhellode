<?php

namespace App\Log;

use App\Core\AbstractModel;

class LogModel extends AbstractModel
{

    public $id;
    public $time;
    public $controller;
    public $msgtype
    public $msg;
    public $user;

}

?>

<?php

namespace App\User;

use App\Core\AbstractModel;

class UserModel extends AbstractModel
{

  public $id;
  public $username;
  public $fullname;
  public $email;
  public $usertype;
  public $grants;
  public $password;

}

<?php

namespace App\User;

use App\User\UserController;

class UserService
{
  public function __construct(UserController $userController)
  {
    $this->userController = $userController;
  }

  public function returnUserById($id)
  {
    return $this->userController->returnUserById($id);
  }

  public function returnGrants()
  {
    return $this->userController->returnGrants();
  }

}

?>

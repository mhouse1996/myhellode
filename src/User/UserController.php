<?php

namespace App\User;

use App\Core\AbstractController;

class UserController extends AbstractController
{

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function checkLoginstate()
  {
    if($this->userService->checkLoginstate()){
      return true;
    }else {
      return false;
    }
  }

  public function returnGrants()
  {
    return $this->userService->returnGrants();
  }

  public function returnUserById($id)
  {
    return $this->userService->fetchUserById($id);
  }

  public function dashboard()
  {
    if($this->checkLoginstate()){
      $this->render("user/dashboard", [
        'user' => $this->userService
      ]);
    }else {
      header("Location: login");
    }
  }

  public function login()
  {
    $error = false;
    if(!empty($_POST['username']) AND !empty($_POST['password']))
    {
      $username = $_POST['username'];
      $password = $_POST['password'];
      if($this->userService->attempt($username, $password))
      {
        header("Location: index");
        return;
      }else {
        $error = true;
      }
    }
    $this->render("user/login", [
      'error' => $error
    ]);
  }

  public function logout()
  {
    $this->userService->logout();
    header("Location: index");
  }

}

?>

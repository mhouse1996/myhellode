<?php

namespace App\User;

use App\Core\AbstractController;

class UserController extends AbstractController
{

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function returnGrants()
  {
    if (isset($_SESSION['grants'])) {
      return $_SESSION['grants'];
    } else {
      return false;
    }
  }

  public function returnUserById($id)
  {
    return $this->userRepository->fetchUserById($id);
  }

  public function dashboard()
  {
    if ($this->returnGrants() > 0) {
      $this->render("user/dashboard", []);
    } else {
      header("Location: login");
    }
  }

  public function attempt($username, $password)
  {
    $user = $this->userRepository->findByUsername($username);
    if(empty($user)){
      return false;
    } else {
      if($user->password == $password){
        session_regenerate_id(true);
        $_SESSION['id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['fullname'] = $user->fullname;
        $_SESSION['usertype'] = $user->usertype;
        $_SESSION['email'] = $user->email;
        $_SESSION['grants'] = $user->grants;
        /*$_SESSION['navbar'] = $this->userRepository->fetchNavbar($user);*/
        return true;
      }else{
        return false;
      }
    }
  }

  public function login()
  {
    $error = false;
    if(!empty($_POST['username']) AND !empty($_POST['password']))
    {
      $username = $_POST['username'];
      $password = $_POST['password'];
      if($this->attempt($username, $password))
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
    session_unset();
    session_destroy();
    header("Location: index");
  }

}

?>

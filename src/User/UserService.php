<?php
namespace App\User;

class UserService
{
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function checkLoginstate()
  {
    if(isset($_SESSION['grants']) AND $_SESSION['grants'] > 0){
      return true;
    }else {
      return false;
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
        $_SESSION['navbar'] = $this->userRepository->fetchNavbar($user);
        return true;
      }else{
        return false;
      }
    }
  }

  public function logout()
  {
    session_unset();
    session_destroy();
  }
}
?>

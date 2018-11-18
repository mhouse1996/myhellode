<?php

namespace App\User;

use App\Core\AbstractController;
use App\Log\LogController;

class UserAdminController extends AbstractController
{

    public function __construct(UserController $userController, LogController $logController, $configs)
    {
      $this->userController = $userController;
      $this->userRepository= $this->userController->userRepository;
      $this->logController = $logController;
      $this->configs = $configs;

      $this->logController->setController("UserAdminController");

      if($this->userController->returnGrants() < $this->configs['user']['adminSysGrantlevel']){
        header("Location: index");
      }

    }

    public function showUserIndex()
    {
      $users = $this->userRepository->all();
      $this->render("admin/user/admin", [
        'users' => $users
      ]);
    }

    public function showUser()
    {
      if(isset($_GET['id'])){

      } else {
        $this->showUserIndex();
      }
    }

}
?>

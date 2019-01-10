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

    public function showUserIndex($users = null)
    {

      if (!isset($users)) {
        $users = $this->userRepository->all();
      } else {
        $users = $users;
      }

      $lastBreaks = [];

      var_dump($users);
      if (is_array($users)) {
        foreach($users as $user)
        {
          var_dump($user);
          $userLog = $this->logController->returnLastBreakByUserId($user->id);
          if ($userLog){
            $lastBreaks[$user->id] = $userLog->time;
          } else {
            $lastBreaks[$user->id] = "N/A";
          }
        }
      }
      
      $this->render("admin/user/admin", [
        'users' => $users,
        'lastBreaks' => $lastBreaks
      ]);
    }

    public function searchUser($user = null)
    {
      if (isset($_POST['keyword'])) {
        $users = $this->userRepository->searchUser(mysql_real_escape_string($_POST['keyword']));
      } else {
        $users = $this->userRepository->searchUser($user);
      }

      if (isset($_GET['ref'])) {
        if ($_GET['ref'] == "showUser") {
          $this->showUserIndex($users);
        }
      } else {
        return $users;
      }
    }

    public function getLastBreaks()
    {
      $lastBreaks = [];

      $logs = $this->logController->returnLogsByMsgType(1);
      foreach($logs as $log)
      {
        if (isset($log->time)){
          $lastBreaks[$log->user] = $log->time;
        } else {
          $lastBreaks[$log->user] = "N/A";
        }
      }

      return $lastBreaks;
    }

    public function showUser()
    {
      if(isset($_GET['id']) && !empty($_GET['id'])){
        $userID = $_GET['id'];
        $logs = $this->logController->returnLogsByUserId($userID);
        $this->render("admin/user/showuserlogs", [
          'logs' => $logs
        ]);
      } else {
        $this->showUserIndex();
      }
    }

}
?>

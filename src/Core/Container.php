<?php

namespace App\Core;

use PDO;
use Exception;
use PDOException;

use App\User\UserAdminController;
use App\User\UserRepository;
use App\User\UserController;
use App\User\UserService;

use App\BreakSystem\BreakRepository;
use App\BreakSystem\BreakController;
use App\BreakSystem\BreakAdminController;

use App\Log\LogController;
use App\Log\LogRepository;

class Container
{
  private $receipts = [];
  private $instances = [];
  private $configs = [];

  public function __construct($configs)
  {
    $this->configs = $configs;
    $this->receipts = [
      'logController' => function()
      {
        return new LogController(
          $this->make('logRepository'),
          $this->make('userService'),
          $this->configs
        );
      },
      'logRepository' => function()
      {
        return new LogRepository(
          $this->make('pdo')
        );
      },
      'breakAdminController' => function()
      {
        return new BreakAdminController(
          $this->make('breakController'),
          $this->make('userService'),
          $this->make('logController')
        );
      },
      'breakController' => function()
      {
        return new BreakController(
          $this->make('userService'),
          $this->make('breakRepository'),
          $this->make('logController'),
          $this->configs
        );
      },
      'breakRepository' => function()
      {
        return new BreakRepository(
          $this->make('pdo')
        );
      },
      'userAdminController' => function()
      {
        return new UserAdminController(
          $this->make('userController'),
          $this->make('logController'),
          $this->configs
        );
      },
      'userService' => function()
      {
        return new UserService(
          $this->make('userController')
        );
      },
      'userController' => function()
      {
        return new UserController(
          $this->make('userRepository')
        );
      },
      'userRepository' => function()
      {
        return new UserRepository(
          $this->make('pdo')
        );
      },
      'pdo' => function() {
        try {
          $pdo = new PDO(
            "mysql:host={$this->configs['mysql']['host']};dbname=myhellode;charset=utf8",
            $this->configs['mysql']['user'],
            $this->configs['mysql']['password']
          );
        } catch (PDOException $e) {
          echo "Verbindung zur Datenbank fehlgeschlagen: {$e}";
          die();
        }
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
      }
    ];
  }

  public function make($name)
  {
    if (!empty($this->instances[$name]))
    {
      return $this->instances[$name];
    }

    if (isset($this->receipts[$name])) {
      $this->instances[$name] = $this->receipts[$name]();
    }

    return $this->instances[$name];
  }
}
 ?>

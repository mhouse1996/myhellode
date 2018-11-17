<?php

namespace App\Core;

use PDO;
use Exception;
use PDOException;

use App\User\UserRepository;
use App\User\UserController;
use App\User\UserService;
use App\BreakSystem\BreakRepository;
use App\BreakSystem\BreakController;

class Container
{
  private $receipts = [];
  private $instances = [];
  private $configs = [];

  public function __construct($configs)
  {
    $this->configs = $configs;
    $this->receipts = [
      'breakController' => function()
      {
        return new BreakController(
          $this->make('userController'),
          $this->make('breakRepository'),
          $this->configs
        );
      },
      'breakRepository' => function()
      {
        return new BreakRepository(
          $this->make('pdo')
        );
      },
      'userController' => function()
      {
        return new UserController(
          $this->make('userService')
        );
      },
      'userService' => function()
      {
        return new UserService(
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
            'mysql:host=localhost;dbname=myhellode;charset=utf8',
            'root',
            ''
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
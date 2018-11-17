<?php
session_start();

require __DIR__ . "/autoload.php";

require __DIR__ . "/configs/configs.php";

function e($str)
{
  return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

$container = new App\Core\Container($configs);

//CHANGED
?>

<?php

class Database
{
  private static $instance;

  public static function getInstance(): PDO
  {
    $servername = getenv('SERVER_NAME');
    $username = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    $dbname = getenv('DB_NAME');
    if (!isset(self::$instance)) {
      try {
        self::$instance = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
        self::$instance->exec("SET NAMES 'utf8'");
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

    return self::$instance;
  }
}

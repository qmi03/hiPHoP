<?php
// Include the Migration class
require_once(__DIR__ . '/migration.php');

// Database configuration
require_once(dirname(__DIR__) . '/config/index.php');
require_once(dirname(__DIR__) . '/config/database.php');
require_once(dirname(__DIR__) . '/config/env.php');

// Initialize migration system
$migration = new Migration(Database::getInstance());

// CLI commands
if (PHP_SAPI === 'cli') {
  $command = $argv[1] ?? 'help';

  switch ($command) {
    case 'create':
      $name = $argv[2] ?? 'unnamed_migration';
      $path = $migration->createMigration($name);
      echo "Created migration at: $path\n";
      break;

    case 'run':
      echo "Running migrations...\n";
      $results = $migration->runMigrations();
      foreach ($results as $file => $result) {
        echo "$file: $result\n";
      }
      if (empty($results)) {
        echo "No migrations to run.\n";
      }
      break;

    case 'status':
      echo "Migration status:\n";
      $status = $migration->getStatus();
      foreach ($status as $file => $state) {
        echo "$file: $state\n";
      }
      if (empty($status)) {
        echo "No migrations found.\n";
      }
      break;

    default:
      echo "Available commands:\n";
      echo "  php migrate.php create [name]  - Create a new migration\n";
      echo "  php migrate.php run           - Run pending migrations\n";
      echo "  php migrate.php status        - Show migration status\n";
  }
}

<?php

/**
 * Simple MySQL Migration System for PHP Projects.
 */
class Migration
{
  private $pdo;
  private $migrationsTable = 'migrations';
  private $migrationsDir = 'migrations';

  /**
   * Constructor.
   *
   * @param PDO    $pdo             PDO connection instance
   * @param string $migrationsTable Name of the migrations tracking table
   * @param string $migrationsDir   Directory containing migration files
   */
  public function __construct(PDO $pdo, $migrationsTable = 'migrations', $migrationsDir = 'migrations')
  {
    $this->pdo = $pdo;
    $this->migrationsTable = $migrationsTable;
    $this->migrationsDir = $migrationsDir;

    // Ensure migrations table exists
    $this->createMigrationsTable();
  }

  /**
   * Run pending migrations.
   *
   * @return array Results of migrations run
   */
  public function runMigrations()
  {
    $executedMigrations = $this->getExecutedMigrations();
    $availableMigrations = $this->getAvailableMigrations();
    $results = [];

    foreach ($availableMigrations as $migration) {
      if (!in_array($migration, $executedMigrations)) {
        try {
          $this->pdo->beginTransaction();

          // Load and execute the migration SQL
          $sql = file_get_contents($this->migrationsDir.'/'.$migration);
          $this->pdo->exec($sql);

          // Record the migration
          $stmt = $this->pdo->prepare("INSERT INTO {$this->migrationsTable} (migration) VALUES (?)");
          $stmt->execute([$migration]);

          $this->pdo->commit();
          $results[$migration] = 'Success';
        } catch (PDOException $e) {
          $results[$migration] = 'Failed: '.$e->getMessage();
        }
      }
    }

    return $results;
  }

  /**
   * Create a new migration file.
   *
   * @param string $name Descriptive name for the migration
   *
   * @return string Path to the created migration file
   */
  public function createMigration($name)
  {
    if (!is_dir($this->migrationsDir)) {
      mkdir($this->migrationsDir, 0755, true);
    }

    // Format name to be filename-friendly
    $name = strtolower(preg_replace('/[^a-z0-9_]/i', '_', $name));

    // Create timestamp prefix for ordering
    $timestamp = date('YmdHis');
    $filename = "{$timestamp}_{$name}.sql";
    $path = $this->migrationsDir.'/'.$filename;

    // Create empty migration file with template
    $template = "-- Migration: {$name}\n-- Created at: ".date('Y-m-d H:i:s')."\n\n-- Write your SQL here\n\n";
    file_put_contents($path, $template);

    return $path;
  }

  /**
   * Get migration status.
   *
   * @return array Status of all migrations
   */
  public function getStatus()
  {
    $executedMigrations = $this->getExecutedMigrations();
    $availableMigrations = $this->getAvailableMigrations();
    $status = [];

    foreach ($availableMigrations as $migration) {
      $status[$migration] = in_array($migration, $executedMigrations) ? 'Executed' : 'Pending';
    }

    return $status;
  }

  /**
   * Create migrations tracking table if it doesn't exist.
   */
  private function createMigrationsTable()
  {
    $sql = "CREATE TABLE IF NOT EXISTS {$this->migrationsTable} (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            migration VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY migration (migration)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $this->pdo->exec($sql);
  }

  /**
   * Get list of executed migrations.
   *
   * @return array List of executed migration names
   */
  private function getExecutedMigrations()
  {
    $stmt = $this->pdo->query("SELECT migration FROM {$this->migrationsTable}");

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }

  /**
   * Get available migration files.
   *
   * @return array List of available migration files
   */
  private function getAvailableMigrations()
  {
    if (!is_dir($this->migrationsDir)) {
      mkdir($this->migrationsDir, 0755, true);

      return [];
    }

    $files = scandir($this->migrationsDir);
    $migrations = [];

    foreach ($files as $file) {
      if ('.' === $file || '..' === $file) {
        continue;
      }

      if (preg_match('/^\d{14}_(.+)\.sql$/', $file)) {
        $migrations[] = $file;
      }
    }

    sort($migrations); // Ensure migrations are ordered

    return $migrations;
  }
}

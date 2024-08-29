<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    protected $signature = 'app:create-database {name}';
    protected $description = 'Create a new database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $databaseName = $this->argument('name');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbUsername = env('DB_USERNAME', 'root');
        $dbPassword = env('DB_PASSWORD', '');

        try {
            $pdo = new \PDO("mysql:host=$dbHost;port=$dbPort", $dbUsername, $dbPassword);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $statement = $pdo->exec("CREATE DATABASE IF NOT EXISTS `$databaseName`");

            if ($statement !== false) {
                $this->info("Database '$databaseName' created successfully.");
            } else {
                $this->error("Failed to create database '$databaseName'.");
            }
        } catch (\PDOException $e) {
            $this->error("Database creation failed: " . $e->getMessage());
        }
    }
}

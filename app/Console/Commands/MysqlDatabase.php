<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MysqlDatabase extends Command
{
    protected $signature = 'db:mysql {action} {name?}';
    protected $description = 'Manage MySQL databases';

    public function handle()
    {
        $action = $this->argument('action');
        $name = $this->argument('name');

        switch ($action) {
            case 'create':
                $this->createDatabase($name);
                break;

            case 'delete':
                $this->deleteDatabase($name);
                break;

            case 'show':
                $this->showDatabases();
                break;

            case 'query':
                $this->runQuery($name);
                break;

            default:
                $this->error('Invalid action. Available actions: create, delete, show, query.');
        }
    }

    protected function createDatabase($name)
    {
        if (empty($name)) {
            $this->error('Database name is required.');
            return;
        }

        // Kiểm tra xem database đã tồn tại hay chưa
        $databaseExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$name]);
        
        if (!empty($databaseExists)) {
            $this->info("Database '$name' already exists.");
            return;
        }

        // Tạo database mới
        DB::statement("CREATE DATABASE `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $this->info("Database '$name' created successfully.");
    }

    protected function deleteDatabase($name)
    {
        if (empty($name)) {
            $this->error('Database name is required.');
            return;
        }

        // Kiểm tra xem database có tồn tại hay không
        $databaseExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$name]);
        
        if (empty($databaseExists)) {
            $this->info("Database '$name' does not exist.");
            return;
        }

        // Xóa database
        DB::statement("DROP DATABASE `$name`");
        $this->info("Database '$name' deleted successfully.");
    }

    protected function showDatabases()
    {
        $databases = DB::select("SHOW DATABASES");

        $this->info("Databases:");
        foreach ($databases as $database) {
            $this->line($database->Database);
        }
    }

    protected function runQuery($query)
    {
        if (empty($query)) {
            $this->error('Query is required.');
            return;
        }
        
        try {
            print_r($query); 
            $results = DB::select($query);
            $this->info("Query executed successfully.");

            if($query === "show tables;" || $query === "SHOW TABLES;"){
                $databaseName = DB::getDatabaseName();            
                $this->info("Query executed successfully.");
                foreach ($results as $result) {
                    $tableNameColumn = "Tables_in_$databaseName";
                    echo $result->$tableNameColumn . "\n";;
                }
            }else{
                print_r($results); 
            }
           // print_r($results);    
        } catch (\Exception $e) {
            $this->error('Error executing query: ' . $e->getMessage());
        }
    }
}
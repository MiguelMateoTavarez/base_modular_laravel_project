# Laravel modular project

## Start the project

* Copy the **.env.example** file and rename it **.env**
* Execute the next command: **composer install**
* Start your docker
* Execute the next command: **./vendor/bin/sail up -d**

## Estructure

* Modules
    * Security
        * Database
            * Migrations
            * Seeders
        * Eloquents
            * Contracts
            * Services
        * Enums
        * Http
            * Controllers
            * Middlewares
            * Requests
            * Resources
        * Models
        * Observers
        * Policies
        * Providers
        * Routes

## Commands

| Command                                                                               | Description                                                           |
|---------------------------------------------------------------------------------------|-----------------------------------------------------------------------|
| php artisan make:module ModuleName                                                    | Create a new module with the necessary directory structure            |
| php artisan make:module-controller ModuleName ResourceController -p CustomPath        | Create a controller for a module                                      |
| php artisan make:module-enum ModuleName ResourceEnum -p CustomPath                    | Create an enum for a module                                           |
| php artisan make:module-interface ModuleName ResourceInterface -p CustomPath          | Create an interface for a module                                      |
| php artisan make:module-middleware ModuleName ResourceMiddleware -p CustomPath        | Create a middleware for a module                                      |
| php artisan make:module-migration ModuleName ResourceMigration                        | Create a migration for a module                                       |
| php artisan make:module-model ModuleName ResourceModel -p CustomPath                  | Create a model for a module                                           |
| php artisan make:module-policy ModuleName ResourcePolicy -m Model -p CustomPath       | Create a policy for a module                                          |
| php artisan make:module-request ModuleName ResourceRequest -p CustomPath              | Create a request for a module                                         |
| php artisan make:module-resource ModuleName ResourceResource -p CustomPath            | Create a resource for a module                                        |
| php artisan make:module-seeder ModuleName ResourceSeeder -p CustomPath                | Create a seeder for a module                                          |
| php artisan make:module-service ModuleName ResourceService -i Interface -p CustomPath | Create a service for a module (Need the same structure as interfaces) |
| php artisan make:module-observer ModuleName ResourceObserver -m Model -p CustomPath   | Create an observer for a model|


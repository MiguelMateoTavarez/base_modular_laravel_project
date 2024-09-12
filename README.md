# Laravel modular project

## Estructure

* Modules
  * Security
    * Database
      * factories
      * migrations
      * seeders
    * Eloquents
      * Services
      * Contracts
    * Enums
    * Http
      * Controllers
      * Middlewares
      * Requests
      * Resources
    * Models
    * Policies
    * Providers
    * Routes

## Commands

| Command                                                                 | Description                                                |
|-------------------------------------------------------------------------|------------------------------------------------------------|
| php artisan make:module ModuleName                                      | Create a new module with the necessary directory structure |
| php artisan make:module-controller ModuleName ResourceController        | Create a controller for a module                           |
| php artisan make:module-enum ModuleName ResourceEnum                    | Create an enum for a module                                |
| php artisan make:module-interface ModuleName ResourceInterface          | Create an interface for a module                           |
| php artisan make:module-middleware ModuleName ResourceMiddleware        | Create an middleware for a module                          |
| php artisan make:module-migration ModuleName ResourceMigration          | Create a migration for a module                            |
| php artisan make:module-model ModuleName ResourceModel                  | Create a model for a module                                |
| php artisan make:module-policy ModuleName ResourcePolicy -m Model       | Create a policy for a module                               |
| php artisan make:module-request ModuleName ResourceRequest              | Create a request for a module                              |
| php artisan make:module-resource ModuleName ResourceResource            | Create a resource for a module                             |
| php artisan make:module-seeder ModuleName ResourceSeeder                | Create a seeder for a module                               |
| php artisan make:module-service ModuleName ResourceService -i Interface | Create a service for a module                              |

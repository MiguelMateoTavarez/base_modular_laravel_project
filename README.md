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

| Command                                                          | Description                                                |
|------------------------------------------------------------------|------------------------------------------------------------|
| php artisan make:module ModuleName                               | Create a new module with the necessary directory structure |
| php artisan make:module-controller ModuleName ResourceController | Create a controller for a module                           |
| php artisan make:module-enum ModuleName ResourceEnum             | Create an enum for a module                                |
| php artisan make:module-interface ModuleName ResourceInterface   | Create an interface for a module                           |
| php artisan make:module-middleware ModuleName ResourceMiddleware | Create an middleware for a module                          |
| php artisan make:module-migration ModuleName ResourceMigration   | Create a migration for a module                            |
| php artisan make:module-model ModuleName ResourceModel           | Create a model for a module                                |
| php artisan make:module-policy ModuleName ResourcePolicy         | Create a policy for a module                               |

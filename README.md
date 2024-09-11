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

| Command                            | Description                                                |
|------------------------------------|------------------------------------------------------------|
| php artisan make:module ModuleName | Create a new module with the necessary directory structure |
| php artisan make:module-controller | Create a controller for a module                           |
| php artisan make:module-enum       | Create an enum for a module                                |
| php artisan make:module-interface  | Create an interface for a module                           |
| php artisan make:module-middleware | Create an middleware for a module                          |
| php artisan make:module-migration  | Create a migration for a module                            |
| php artisan make:module-model      | Create a model for a module                                |
| php artisan make:module-policy     | Create a policy for a module                               |

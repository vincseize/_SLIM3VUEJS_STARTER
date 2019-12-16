# Slim 3 Starter WIP

- Restful API
- Crud API
- Dynamics Routes
- includes Twig, Flash messages Monolog, Faker libraries
- includes Bootstrap 3.0.2, own styles.css

Backend : 
- Auto-tables
- Pagination

Frontend : 
- VueJs

## Create your project:

    $ composer create-project --no-interaction --stability=dev akrabat/slim3-skeleton my-app

    composer dump-autoload

    https://getcomposer.org/doc/04-schema.md#psr-4

### Run it:

1. `$ 127.0.0.1/my-app/public/index.php`
2. `or`
3. `$ cd my-app`
4. `$ php -S 0.0.0.0:8888 -t public public/index.php`
5. Browse to http://localhost:8888

## Key directories

* `app`: Application code
* `app/src`: All class files within the `App` namespace
* `app/templates`: Twig template files
* `cache/twig`: Twig's Autocreated cache files
* `log`: Log files
* `public`: Webserver root
* `vendor`: Composer dependencies

## Key files

* `public/index.php`: Entry point to application
* `app/settings.php`: Configuration
* `app/dependencies.php`: Services for Pimple
* `app/middleware.php`: Application middleware
* `app/routes.php`: All application routes are here
* `app/src/Action/HomeAction.php`: Action class for the home page
* `app/templates/home.twig`: Twig template file for the home page

## Routes

* `public/api/test`: Api test with Faker data

## SQL

* `dbname`: booking_vuejs
* `sql`: booking_vuejs.sql

## Usages
* `tests`: to write...

## Todo

* `twig`: send data
* `crud`: delete update
* `restful`: delete update

## Changelog

* `npm by`: npm install -g auto-changelog / https://github.com/CookPete/auto-changelog#what-you-might-do-if-youre-clever


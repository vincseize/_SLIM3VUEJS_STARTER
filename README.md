[![GitHub version](https://img.shields.io/badge/version-dev-green)](version-dev-green)
[![GitHub releases](https://img.shields.io/badge/release-v0.5.1-blue)](https://img.shields.io/badge/release-v0.5.1-blue)
[![GitHub issues](https://img.shields.io/github/issues/vincseize/_PAGINATION)](https://github.com/vincseize/_PAGINATION/issues)
[![GitHub forks](https://img.shields.io/github/forks/vincseize/_PAGINATION)](https://github.com/vincseize/_PAGINATION/network)
[![GitHub stars](https://img.shields.io/github/stars/vincseize/_PAGINATION)](https://github.com/vincseize/_PAGINATION/stargazers)
[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs)

# Slim 3 Starter Backend, Frontend VueJs ... WIP

- Restful API
- Dynamic Routes
- includes Twig, Flash messages, Monolog, Faker, Libraries
- includes Bootstrap 3.0.2, own styles.css
- Own classes.php

Backend : 

- Auto-tables
- Pagination
- Search by filters
- Crud for sure

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
* `app/src`: ...
* `app/src/templates`: Twig template files
* `cache/twig`: Twig's Autocreated cache files
* `log`: Log files
* `public`: Webserver root
* `vendor`: Composer dependencies

## BACKEND

## Key files

* `public/index.php`: Entry point to application
* `app/settings.php`: Configuration
* `app/dependencies.php`: Services for Pimple
* `app/middleware.php`: Application middleware
* `app/routes.php`: All application routes are here
* `app/src/Action/ApiAction.php`: Action class for the backend page
<!-- * `app/templates/home.twig`: Twig template file for the home page -->

## Routes

* `public/api/test`: Api test with Faker data

## SQL

* `dbname`: booking_vuejs
* `sql`: booking_vuejs.sql

## Usages
* `tests`: to do...

## Restful
<!-- update
http://127.0.0.1/_SLIM3VUEJS_STARTER/backend/public/api/clients/update/984/toto -->

## Issues

* `order`: double ... click
* `url`: url testApi/... empty -> to clients or first table?

## Todo

* `twig`: form one twig
* `filters`: all
* `col`: check
* `col`: list 
* `col`: list from other table
* `col`: upload image
* `col`: date calendar
* `ajax`: table
* `curl`: fct
* `js`: scoped and minify several
* `php`: cst check

## Changelog

* `npm by`: npm install -g auto-changelog / https://github.com/todo


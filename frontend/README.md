# SlimApp RESTful API

This is a RESTful api built with the SlimPHP framework and uses MySQL for storage.

### Version
1.0.0

### Usage


### Installation

Create database or import from ../_sql/booking_vuejs.sql

Edit src/config/db params

Install SlimPHP and dependencies

```sh
$ composer
```


## Installation

```sh
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build
```


### API Endpints
```sh
$ GET /api/customers
$ GET /api/customer/{id}
$ POST /api/customer/add
$ PUT /api/customer/update/{id}
$ DELETE /api/customer/delete/{id}
```

## Create your project:

<!-- $ composer create-project --no-interaction --stability=dev akrabat/slim3-skeleton my-app

composer dump-autoload

https://getcomposer.org/doc/04-schema.md#psr-4 -->

## BACKEND

## Key directories

* `app`: Application code
* `app/src`: ...
* `app/src/templates`: Twig template files
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
* `app/src/Action/ApiAction.php`: Action class for the backend page
<!-- * `app/templates/home.twig`: Twig template file for the home page -->

## Routes

* `public/api/test`: Api test with Faker data

## SQL

* `dbname`: booking_vuejs
* `sql`: booking_vuejs.sql

### Run it:

1. `$ 127.0.0.1/my-app/public/index.php`
2. `or`
3. `$ cd my-app`
4. `$ php -S 0.0.0.0:8888 -t public public/index.php`
5. Browse to http://localhost:8888

## Restful
<!-- update
http://127.0.0.1/_SLIM3VUEJS_STARTER/backend/public/api/clients/update/984/toto -->

## First Issues

* `url rewriting`: dist server
* `login`: login password page
* `url`: url testApi/... empty -> to first table as default
* `filter`: with empty values

## Todo

* `docs`: backend, frontend (favicon)
* `doublons accepted true false`: add update
* `session check`: login password page
* `rename / delete api routes`: TestapiAction -> ApiAction, delete unused ...
* `message`: return info
* `twig`: form one twig
* `col`: check
* `col`: list 
* `col`: list from other table
* `col`: upload image
* `col`: date calendar
* `filter`: multi col , different choices possible
* `ajax`: table
* `curl`: fct
* `js`: scoped and minify several
* `php`: cst check
* `url`: test with added neutral random var
* `path js`: global vars
* `path php`: to settings
* `middleware`: to test

## Changelog

* `npm by`: npm install -g auto-changelog / https://github.com/todo



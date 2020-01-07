# VueJs.2. Starter

This is a VueJs built with the SlimPHP framework and uses MySQL for storage.

### Installation

- Edit src/config/db.php params
- Edit src/main.js params
//global variables
window.base_url : 'your-project-folder-name', (eg: _SLIM3VUEJS_STARTER-master)

- Edit src/main.js params
//global variables
window.base_url : 'your-project-folder-name', (eg: _SLIM3VUEJS_STARTER-master)

- Install VueJs and dependencies

```sh
# install vendor
$ composer (composer install)

# install dependencies
$ npm install

# serve with hot reload at localhost:8000
$ npm run dev

# build for production with minification, 
# http://127.0.0.1/[your-project-folder-name]/frontend/dist/
$ npm run build
```

### API Endpints
```sh
$ GET /api/customers
$ GET /api/customer/{id}
$ POST /api/customer/add
$ PUT /api/customer/update/{id}
$ DELETE /api/customer/delete/{id}
```

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

## First Issues

* `none`:

## Todo

* `url root`: js glob var

## Changelog

* `npm by`: npm install -g auto-changelog / https://github.com/todo



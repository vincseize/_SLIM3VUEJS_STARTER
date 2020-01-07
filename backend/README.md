# Slim.3. Starter

This is a SlimPHP framework and uses MySQL for storage.

### Installation

- Edit src/config/db.php params

- Edit src/main.js params
//global variables
window.base_url : 'your-project-folder-name', (eg: _SLIM3VUEJS_STARTER-master)

- Edit config/index.js params
assetsPublicPath:  : 'your-project-folder-name', (eg: _SLIM3VUEJS_STARTER-master)

- Install Slim 3. and dependencies

```sh
$ cd your-project-folder-name/backend

# install vendor
$ composer install

# install dependencies
$ npm install

# serve with hot reload at localhost:8080
$ npm run dev

# build for production with minification, 
# http://127.0.0.1/[your-project-folder-name]/frontend/dist/
$ npm run build
```
- favicon : copy a icon into -> dist/assets/favicon.png

## Key directories

* `src`: Application code
* `src/routes`: routes directory
* `src/routes/clients.php`: sample table api
* `dist`: builded files
* `public`: Webserver root, entry point
* `vendor`: Composer dependencies

## Key files

* `routes`: define, add route: public/index.php
* `src/routes/clients.php`: Api Crud for Table Clients

## First Issues

* `none`:

## Todo

* `favicon`: path for buil or auto copy
* `url root`: js glob var

<!-- ## Changelog

* `npm by`: npm install -g auto-changelog / https://github.com/todo -->



# laravel

...

## dependencies

- php 8.4+
- composer 2.8+

## setup

```bash
composer install # install dependencies
touch ./database/database.sqlite # create database
php artisan migrate:fresh --seed # seed database
php artisan serve # start development server
```

## common issues

- php installed via xampp might cause issues. if that happens, install it with homebrew/scoop instead.
- php might be compiled without certain modules (e.g. pdo_sqlite). if so, manually enable them in ini file.
- your anti virus might block/delete files inside laravel. if so, whitelist the folder.


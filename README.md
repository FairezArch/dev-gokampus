
## Setup Testing

Installing Composer
- composer install

Migrate database and seeder
- php artisan migrate --seed

Setup storage link for file upload
- php artisan storage:link

Generate event
- php artisan event:generate

Run laravel
- php artisan serve

## Setup Testing API

Using Thunder Client

Import collection and env
- Import file in thunder-client thunder-collection_gokampus for collection
- Import file in thunder-environment_gokampus-testing for env

Set env for collection
- Open settings in file thunder-client thunder-collection_gokampus -> Environment -> select Environment 'gokampus-testing'


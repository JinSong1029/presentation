Walker Morris Opt
=====================

Installation
------------

Clone the repository into a web directory.
Please configure apache to look at the project root directory.

Please note that directory, storage/ requires a write permissions for application to work.

After configuring apache and directories permissions you have to rename **.env.example** to **.env** and edit

Database configuration variables:

    DB_HOST=localhost
	DB_DATABASE=walker_morris
	DB_USERNAME=root
	DB_PASSWORD=123123

Environment specific variables - app has Admin & View modes:

    APP_MODE - can be omitted for for view mode, should be - dashboard when working with admin panel.

    ASSET_HOST - should be set in view mode, overrides default assets path(https://dashboard.walkermorris.co.uk) can be blank

    ONE_FOLDER_MODE - (true, false, omitted) dev only. For the app to be able to serve dashboard domain(like wmdashboard.flatearth.co.uk) and view domains(like wmpresenting.flatearth.co.uk,wmclients.flatearth.co.uk) from one server folder. Domain names containing `dashboard` will have dashboard mode regardless of APP_MODE variable above.

Then run a console command from the root directory of a project:

    php artisan migrate
    php artisan db:seed

Then you should be able to access your application on a configured domain.

Envoirenment and code dependencies
----------------------------------

The application requires this server envoirenment

 - PHP >= 5.5.9
 - OpenSSL PHP Extension
 - PDO PHP Extension
 - Mbstring PHP Extension
 - Tokenizer PHP Extension

The code contains these packages and dependencies

    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.1.*",
        "barryvdh/laravel-ide-helper": "^2.0",
        "illuminate/html": "^5.0",
        "laracasts/presenter": "^0.2.1",
        "itsgoingd/clockwork": "^1.8",
        "codeception/codeception": "^2.1@dev",
        "zizaco/entrust": "dev-laravel-5",
        "barryvdh/laravel-dompdf": "^0.6.0",
        "doctrine/dbal": "^2.5",
        "laracasts/testdummy": "^2.3"
    },
    "require-dev": {
        "fzaninotto/faker": "~1.4",
        "mockery/mockery": "0.9.*",
        "phpunit/phpunit": "~4.0",
        "phpspec/phpspec": "~2.1"
    },


All stylesheet's source files are located in **resources/assets/** directory.

To edit css you have to run a build tool.

```
    cd resources/assets
    gulp
```
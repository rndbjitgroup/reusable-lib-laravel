<?php 

namespace Bjit\ReusableLib\Enums;

abstract class ReusableLibEnum 
{
    const APP_NAME = 'Reusable Library';
    const DEFAULT_ZERO = 0;
    const DEFAULT_ONE = 1;
    const DEFAULT_TWO = 2;
    const DEFAULT_THREE = 3;
    const DEFAULT_FALSE = false;
    const DEFAULT_TEXT = 'default';
    const ADDITIONAL_TEXT = 'additional';
    const DEFAULT_LANG = 'English';
    const DEFAULT_LANG_SHORT_FORM = 'en';
    const LANG_NA_INDEX = 3;
    const LANG_NA = 'NA';
    const CAMEL_CASE = 'camelCase';
    const SNACK_CASE = 'snack_case';
    const LARAVEL_VERSION_EIGHT = 8;
    const LARAVEL_VERSION_NINE = 9;

    const LANGS = [
        'English', 'Japanese', 'Arabic', 'Spanish', 'French', 
        //'Chinese', 'Bengali', 
        'NA'
    ];

    const LANGS_SHORT_FORM = [
        'English' => 'en', 'Japanese' => 'ja', 'Arabic' => 'ar', 'Spanish' => 'es', 'French' => 'fr', 
        //'Chinese' => 'zh', 'Bengali' => 'bn'
    ];

    const API_AUTHS = [
        'Sanctum', 'Passport', 'JWT', 'None'
    ];

    const COMPOSER_AUTOLOAD = 'composer du';

    const API_AUTH_SANCTUM = 'Sanctum';
    const API_AUTH_PASSPORT = 'Passport';
    const API_AUTH_JWT = 'JWT';
    const API_AUTH_NONE = 'None';
    //const API_SELECTED_AUTH = 'Sanctum';

    const API_AUTH_COMPOSER_COMMAND = [
        'Sanctum' => 'composer require  "laravel/sanctum"', 
        'Passport' => 'composer require laravel/passport --with-all-dependencies',
        'JWT' => 'composer require "tymon/jwt-auth"',
        // 'Sanctum' => 'composer require  "laravel/sanctum:~2.15"', 
        // 'Passport' => 'composer require "laravel/passport:~10.3"',
        // 'JWT' => 'composer require "tymon/jwt-auth:~1.0"',
    ];

    const API_AUTH_COMPOSER_REMOVE_COMMAND = [
        'Sanctum' => 'composer remove laravel/sanctum', 
        'Passport' => 'composer remove laravel/passport',
        'JWT' => 'composer remove tymon/jwt-auth',
    ];

    const DEFAULT_ROLE_AND_PERMISSION = 'Customized Permission and Role';
    const PERMISSIONS_AND_ROLES = [
        'Customized Permission and Role', 
        //'Passport Scope', 
        'NA'
    ];

    //const OPEN_API_COMPOSER_COMMAND = 'composer require "darkaonline/l5-swagger:8.1"'; // OPEN API - SWAGGER
    const OPEN_API_COMPOSER_COMMAND = 'composer require "darkaonline/l5-swagger"'; // OPEN API - SWAGGER  
    const BOILERPLATE_COMMAND = 'bjit:boilerplate-install';

    const OPEN_API_COMPOSER_REMOVE_COMMAND = 'composer remove "darkaonline/l5-swagger"'; // OPEN API - SWAGGER 
    const BOILERPLATE_REMOVE_COMMAND = 'bjit:boilerplate-remove';

    const OPEN_API_ARTISAN_PUBLISH_COMMMAND = 'php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"';
    
    // const EXTRA_FILES_FOR_REUSABLE_LIB_DELETE = [
    //     ['path' => 'config/l5-swagger.php'],    
    // ]; 

    const ROLE_CUSTOM_TITLE = 'Customized Permission and Role';
    

    // const EXTRA_DIRECTORIES_FOR_REUSABLE_LIB_DELETE = [ 
    //     ['path' => 'resources/views/vendor/l5-swagger']
    // ];

    const AUTHORIZATION_ARTISAN_COMMAND = [
        'Customized Permission and Role' => 'bjit:authorization-install',  
    ];

    const AUTHORIZATION_ARTISAN_REMOVE_COMMAND = [
        'Customized Permission and Role' => 'bjit:authorization-remove',  
    ];

    const MIGRATION_DATE_STRING_LAST_POS = 18;

    //const COMPOSER_COMMAND_IMAGE_RESIZE = 'composer require "intervention/image:~2.7"';
    const COMPOSER_COMMAND_IMAGE_RESIZE = 'composer require "intervention/image"';
    const COMPOSER_COMMAND_REMOVE_IMAGE_RESIZE = 'composer remove intervention/image';
    const ARTISAN_COMMAND_BLOG = 'bjit:blog-install';
    const ARTISAN_COMMAND_REMOVE_BLOG = 'bjit:blog-remove';
    const ARTISAN_MIGRATE_FRESH = 'php artisan migrate:fresh --seed';
    const ARTISAN_PASSPORT_COMMAND = 'php artisan passport:install';
    const API_AUTH_JWT_VENDOR_PUBLISH = 'php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"';
    const API_AUTH_JWT_SECRET = 'php artisan jwt:secret --force';
    const IS_BLOG_YES = 'blog-yes';

    const ARTISAN_COMMAND_CENTRALIZED_MULTIPLE_FILE = 'bjit:centralized-multiple-file-install';
    const ARTISAN_COMMAND_REMOVE_CENTRALIZED_MULTIPLE_FILE = 'bjit:centralized-multiple-file-remove';

    const ARTISAN_COMMAND_NOTIFICATION = 'bjit:notification-install';
    const ARTISAN_COMMAND_REMOVE_NOTIFICATION = 'bjit:notification-remove';
    const ARTISAN_COMMAND_NOTIFICATION_DATABSE = 'php artisan notifications:table';
    //const COMPOSER_COMMAND_PSR7 = 'composer require "guzzlehttp/psr7:^1.7"';
    const COMPOSER_COMMAND_PSR7 = 'composer require "guzzlehttp/psr7"';
    const COMPOSER_COMMAND_REMOVE_PSR7 = 'composer remove guzzlehttp/psr7';
    //const COMPOSER_COMMAND_PUSHER = 'composer require "pusher/pusher-php-server:^5.0"';
    const COMPOSER_COMMAND_PUSHER = 'composer require "pusher/pusher-php-server"';
    const COMPOSER_COMMAND_REMOVE_PUSHER = 'composer remove pusher/pusher-php-server';
    //const COMPOSER_COMMAND_WEBSOCKET = 'composer require "beyondcode/laravel-websockets:^1.12"';
    const COMPOSER_COMMAND_WEBSOCKET = 'composer require "beyondcode/laravel-websockets" --with-all-dependencies';
    const COMPOSER_COMMAND_REMOVE_WEBSOCKET = 'composer remove beyondcode/laravel-websockets';

    const SEEDER_MAIN_FILE = 'DatabaseSeeder.php';
    const MODEL_USER = 'User.php';
    const MODEL_BASE_MODEL = 'BaseModel.php';
    const EXCEPTION_HANDLER = 'Handler.php';
    const CONFIG_APP = 'app.php';
    const CONFIG_BROADCASTING = 'broadcasting.php';
    const HTTP_KERNEL = 'Kernel.php';

    const OPEN_API_ENV_VARIABLES = [
        "\nFE_APP_URL=http://localhost:8000\n",
        'L5_SWAGGER_CONST_HOST="${APP_URL}/api/v1"' . "\n",
        'L5_SWAGGER_GENERATE_ALWAYS=true' . "\n"
    ];

    const OPEN_API_CONFIG_TEXTS = [
        "// 'constants'" => "'constants'",
        "// 'L5_SWAGGER_CONST_HOST'" => "    'L5_SWAGGER_CONST_HOST'",
        "// ]," => "],",
    ];

    const DEFAULT_LANG_FILES = [
        'auth.php', 'pagination.php', 'passwords.php', 'validation.php'
    ];

    const NOTIFICATION_TYPES = [
        'Email', 'Database', 'Push'
    ];

    const NOTIFICATION_EMAIL = 'Email';
    const NOTIFICATION_DATABASE = 'Database';
    const NOTIFICATION_PUSH = 'Push';
    const APP_NOTIFICATIONS_FOLDER = 'Notifications';
    const APP_EVENTS_FOLDER = 'Events';
    const ROOT_FILES = 'RootFiles';
    
    const PUSHER_APP_ID = 912345678;
    const PUSHER_APP_KEY = 'scvbmzkmvcscvbmzkmvcscvbmzkmvcbjit';
    const PUSHER_APP_SECRET = 'xcnmcxdfgvcxcnmcxdfgvcxcnmcxdfgvcbjit';
}
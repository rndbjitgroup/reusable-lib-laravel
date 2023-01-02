# BJIT Reusable Library Package
This is the reusable library package for Laravel. There are some reusable modules.

## Features

- Boilerplate Structure 
- Auth Module 
- Sample Module 
- Permissions and Roles Module  
- Blog Module  
- Certralized Multiple File
- Notifications (Email, Database and Push)

The Reusable Library Package is a lightweight Laravel package.

## Installation

The Reusable Library requires
- **[Laravel](https://laravel.com/) v8+ to run.** 
- **enable the "exec" function in php.ini**  
- **Composer 2+(Recommended)**

Install the Laravel project by following this link
**[Laravel Document](https://laravel.com/docs)** or use the below command:
```sh 
composer create-project laravel/laravel rl-demo
```

Install the Reusable Library package. Use the below command:

```sh
cd rl-demo(your project root)
composer require bjitgroup/reusable-lib-laravel
```

#### Configure the .env file
**Confirm the database connection** 
The correct **APP_URL** must be specified in the.env file. For example,
```sh
APP_URL=localhost:8000 
```

#### To install the reusable library package, use the below command: 
```sh
php artisan bjit:reusable-lib-install
```

#### Verify the deployment by navigating to your server address in your preferred browser. Use the below command:

```sh
php artisan serve 
```

##### For Websocket 

If you choose push notification while setting up the reusable library, you have to run the below command:

```sh 
php artisan websocket:serve
```

#### To get Open API (Swagger) documentation
- Click on one of your preferred browsers.
- Copy **localhost:8000/api/documentation** and paste it in the browser's url.


## File Structure 
File structure flow is as follow
1. Route - Configure the route path.
2. Controller - Write code as simply as possible in the controller, and call Request Class in the method parameter.
3. Request - Form validation is required in this class.  
4. Service - Write business logic and response data (API).
5. Repository - Create, retrieve, update, and delete are actioned in this section.   
6. Resource - Return the response from service in this section and format it if necessary. 

#### To generate the required files for the structure, use the below command:
```sh
php artisan bjit-make:model Products/Item -m --all
```
1. m => migration 
2. s => seed 
3. f => factory

This **_-mfs --all_** can be used at the end of the above command.
#### To remove a specific module (all files), use the below command:
```sh
php artisan bjit-remove:all Products/Item
```

#### To remove the reusable library package, use the below command:
```sh
php artisan bjit:reusable-lib-remove
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# BJIT Reusable Library Package
This is the reusable library package for laravel, there has some reusable module

## Features

- Boilerplate Structure 
- Auth Module 
- Sample Module 
- Permissions and Roles Module  
- Blog Module  
- Certralized Multiple File
- Notifications (Email, Database and Push)

Reusable Library Package is a lightweight laravel Package 

## Installation

Reusable Library requires 
- **[Laravel](https://laravel.com/) v8+ to run.** 
-  **enable exec function in php.ini**  
- **Composer 2+(Recommended)**

Install the laravel project from this link
**[Laravel Document](https://laravel.com/docs)** or run below command
```sh 
composer create-project laravel/laravel rl-demo
```

Install Reusable Library the package.

```sh
cd rl-demo(your project root)
composer require bjitgroup/reusable-lib-laravel
```

#### Configure .env file 
**Confirm database connection** 
In .env file you must set **right APP_URL**. Such as  
```sh
APP_URL=locahost:8000 
```

#### To install reusable library the package 
```sh
php artisan bjit:reusable-lib-install
```

#### Verify the deployment by navigating to your server address in your preferred browser.

```sh
php artisan serve 
```

##### For Websocket 

If you choose push notification from the reusable library, You have to run below command 

```sh 
php artisan websocket:serve
```

#### To get Open API(Swagger) documentation
- Click one your preferred browser
- copy **localhost:8000/api/documentation** and paste it in the browser url


## File Structure 
File structure flow is as follow
1. Route - Configure route path.
2. Controller - Write code as simple as possible in the controller and Call Requst Class in method.  
3. Request - Form validation in this class.  
4. Service - Write Business logic and response data. 
5. Repository - Insert, Update, Retrieve and Delete data in here.   
6. Resource - Return response in here from service.

#### To generate the required files for the structure to use a command
```sh
php artisan bjit-make:model Products/Item -m --all
```
1. m => migration 
2. s => seed 
3. f => factory

We can use for all **_-mfs --all_** 
#### To remove specific module/function files  to use a command
```sh
php artisan bjit-remove:all Products/Item
```

#### To remove reusable library the package
```sh
php artisan bjit:reusable-lib-remove
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


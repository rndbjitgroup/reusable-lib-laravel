# BJIT Reusable Library Package
### _This is the reusable library package there has some reusable module_

## Features

- Boilerplate Structure 
- Auth Module 
- Sample Module 
- Permissions and Roles Module  
- Blog Module  

Reusable Library Package is a lightweight laravel Package 

## Installation

Reusable Library requires 
- **[Laravel](https://laravel.com/) v8+ to run.** 
-  **enable exec function in php.ini**  
- **Composer 2+**

Install the laravel project from this link
**[Laravel Document](https://laravel.com/docs)** or run below command
```sh 
composer create-project laravel/laravel rl-demo
```

Install Reusable Library the package.

```sh
cd your project root
composer require bjit/reusable-lib-laravel
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
php artisan bjit-make:model Products/Item
```

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


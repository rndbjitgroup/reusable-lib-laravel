# BJIT Reusable Library Package

&#x20;

## Overview

The **BJIT Reusable Library Package** is a lightweight and modular Laravel package designed to provide reusable components and features to streamline development.

### **Features**

- 🔥 **Boilerplate Structure**
- 🔐 **Auth Module**
- 🏗 **Sample Module**
- 🎛 **Permissions & Roles Management**
- 📝 **Blog Module**
- 📁 **Centralized File Handling**
- 🔔 **Notifications (Email, Database, Push)**

---

## **Installation**

### **Requirements**

- **Laravel** v8+ (Latest Supported)
- **PHP** with `exec` function enabled
- **Composer** v2+ (Recommended)

### **Version Compatibility**
<table>
  <thead>
    <tr>
      <th>Laravel Version</th>
      <th>Package Version</th>
      <th>Installation Command</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>11.x</td>
      <td>Latest</td>
      <td><code>composer require bjitgroup/reusable-lib-laravel</code></td>
    </tr>
    <tr>
      <td>9.x to 10.x</td>
      <td>2.x</td>
      <td><code>composer require bjitgroup/reusable-lib-laravel:2.*</code></td>
    </tr>
    <tr>
      <td>8.x</td>
      <td>1.x</td>
      <td><code>composer require bjitgroup/reusable-lib-laravel:1.*</code></td>
    </tr>
  </tbody>
</table>

### **Step 1: Install Laravel**

```sh
composer create-project laravel/laravel rl-demo
```

### **Step 2: Install the Reusable Library**

```sh
cd rl-demo  # Navigate to the project root
composer require bjitgroup/reusable-lib-laravel
```

### **Step 3: Configure the .env File**

Ensure the correct database connection and `APP_URL` settings:

```sh
APP_URL=http://localhost:8000
```

### **Step 4: Install the Reusable Library**

```sh
php artisan bjit:reusable-lib-install
```

### **Step 5: Serve the Application**

```sh
php artisan serve
```

---

## **Push Notification Setup**

### **For Laravel 11.x (Reverb)**

```sh
php artisan reverb:start
```

### **For Laravel 8.x - 10.x (Websockets)**

```sh
php artisan websocket:serve
```

### **For Queue Processing**

```sh
php artisan queue:work
```

### **Client-Side Configuration**

- Configure the client application with **Key, Host, and Port**.
- Build the frontend application:

```sh
npm run build
```

---

## **API Documentation (Swagger)**

Access the API documentation by opening your browser and navigating to:

```
http://localhost:8000/api/documentation
```

---

## **File Structure**

The package follows a modular structure:

1. **Route** - Configure API routes.
2. **Controller** - Handle requests and responses.
3. **Request** - Form validation logic.
4. **Service** - Business logic handling.
5. **Repository** - Database operations (CRUD).
6. **Resource** - API response formatting.

### **Generate Module Files**

```sh
php artisan bjit-make:model Products/Item -m --all
```

**Options:**

- `-m` → Create migration
- `-s` → Create seed file
- `-f` → Create factory

You can also use `-mfs --all` at the end of the command to generate a migration, seed, and factory simultaneously.

### **Generate Service or Repository**

```sh
php artisan bjit-make:service Products/ProductBrand
php artisan bjit-make:repository Products/ProductBrand
```

### **Remove a Module**

```sh
php artisan bjit-remove:all Products/Item
```

### **Uninstall Reusable Library**

```sh
php artisan bjit:reusable-lib-remove
```

---

## **License**

This package is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).


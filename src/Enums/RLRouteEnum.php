<?php 

namespace Bjit\ReusableLib\Enums;

abstract class RLRouteEnum 
{
    const ROUTE_BASIC = 'basic';
    const ROUTE_BOILERPLATE = 'boilerplate';
    const ROUTE_CUSTOM_PERMISSION_ROLE = 'customized_permission_and_role';
    const ROUTE_BLOG = 'blog';
    const ROUTE_CENTRALIZED_MULTIPLE_FILE = 'centralized_multiple_file';
    const ROUTE_NOTIFICATION_SYSTEM = 'notification_system';

    const ROUTE_API = [
        'basic' => [
            'group_start' => "\nRoute::prefix('v1')->group(function() {\n",
            'group_end' => "\n});\n",
            'auth_start' => "    Route::middleware(['auth:sanctum', \App\Http\Middleware\AuthGates::class])->group( function () {\n",
            'auth_start_without_auth_gate' => "    Route::middleware(['auth:sanctum'])->group( function () {\n",
            'auth_end' => "    });\n",
        ],
        'boilerplate' => [
            "without_auth" => [
                "    Route::post('register', [\App\Http\Controllers\API\Auth\RegisterController::class, 'register']);\n",
                "    Route::post('forgot-password', [\App\Http\Controllers\API\Auth\ForgotPasswordController::class, 'forgotPassword'])->name('password.forgot');\n",
                "    Route::post('reset-password', [\App\Http\Controllers\API\Auth\ResetPasswordController::class, 'resetPassword'])->name('password.reset');\n",
                "    Route::post('login', [\App\Http\Controllers\API\Auth\LoginController::class, 'login']);\n\n"
            ],
            "auth" => [
                "        Route::post('update-profile', [\App\Http\Controllers\API\Profile\ProfileController::class, 'update']);\n",
                "        Route::post('change-password', [\App\Http\Controllers\API\Profile\ChangePasswordController::class, 'update']);\n",
                "        Route::post('logout', [\App\Http\Controllers\API\Auth\LoginController::class, 'logout']);\n",
                "        Route::get('samples/list', [\App\Http\Controllers\API\Samples\SampleController::class, 'list']);\n",
                "        Route::get('samples/show-common-arr/{sample}', [\App\Http\Controllers\API\Samples\SampleController::class, 'showCommon']);\n",
                "        Route::resource('samples', \App\Http\Controllers\API\Samples\SampleController::class);\n",
            ],
        ],
        'customized_permission_and_role' => [
            "auth" => [
                "        Route::resource('roles', \App\Http\Controllers\API\PermissionsAndRoles\RoleController::class);\n",
                "        Route::resource('permissions', \App\Http\Controllers\API\PermissionsAndRoles\PermissionController::class);\n",
                "        Route::get('users/list', [\App\Http\Controllers\API\Users\UserController::class, 'list']);\n",
                "        Route::resource('users', \App\Http\Controllers\API\Users\UserController::class);\n",
            ]
        ],
        'blog' => [
            "auth" => [
                "        Route::resource('categories', \App\Http\Controllers\API\Blogs\CategoryController::class);\n",
                "        Route::get('categories/{category:slug}', [\App\Http\Controllers\API\Blogs\CategoryController::class, 'show']);\n",
                "        Route::resource('posts', \App\Http\Controllers\API\Blogs\PostController::class);\n",
                "        Route::get('posts/{post:slug}', [\App\Http\Controllers\API\Blogs\PostController::class, 'show']);\n",
                "        Route::post('posts/{post:slug}/comments', [\App\Http\Controllers\API\Blogs\CommentController::class, 'store']);\n",
                "        Route::post('posts/{post:slug}/comments/reply', [\App\Http\Controllers\API\Blogs\CommentController::class, 'storeReply']);\n",
            ]
        ],
        'centralized_multiple_file' => [
            "auth" => [
                "        Route::resource('product-categories', \App\Http\Controllers\API\Products\ProductCategoryController::class);\n",
                "        Route::get('product-categories/{product_category:slug}', [\App\Http\Controllers\API\Products\ProductCategoryController::class, 'show']);\n",
                "        Route::resource('products', \App\Http\Controllers\API\Products\ProductController::class);\n",
                "        Route::get('products/{product:slug}', [\App\Http\Controllers\API\Products\ProductController::class, 'show']);\n",
            ]
        ],
        'notification_system' => [
            "without_auth" => [
                "    Route::get('/notifications/email', [\App\Http\Controllers\API\Notifications\EmailNotificationController::class, 'notify']);\n\n",
                "    Route::get('/notifications/database', [\App\Http\Controllers\API\Notifications\DatabaseNotificationController::class, 'notify']);\n\n",
                "    Route::get('/notifications/both', [\App\Http\Controllers\API\Notifications\BothNotificationController::class, 'notify']);\n\n",
                "    Route::get('/notifications/push', [\App\Http\Controllers\API\Notifications\PushNotificationController::class, 'notify']);\n\n",
            ]
        ]
    ];
}
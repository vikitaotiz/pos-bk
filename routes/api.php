<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\BillController;


Route::group(['prefix' => 'v1'], function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], function(){
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::resource('users', UserController::class);

        Route::resource('roles', RoleController::class);
        Route::post('delete_role', [RoleController::class, 'destroy']);
        Route::post('update_role', [RoleController::class, 'update']);

        Route::resource('departments', DepartmentController::class);
        Route::post('delete_department', [DepartmentController::class, 'destroy']);
        Route::post('update_department', [DepartmentController::class, 'update']);

        Route::resource('categories', CategoryController::class);
        Route::post('delete_category', [CategoryController::class, 'destroy']);
        Route::post('update_category', [CategoryController::class, 'update']);

        Route::resource('products', ProductController::class);
        Route::post('delete_product', [ProductController::class, 'destroy']);
        Route::post('update_product', [ProductController::class, 'update']);

        Route::resource('sales', SaleController::class);
        Route::post('delete_sale', [SaleController::class, 'destroy']);
        Route::post('update_sale', [SaleController::class, 'update']);
        Route::get('sales_last_seven_days', [SaleController::class, 'salesLastSevenDays']);
        Route::post('create_bill_sales', [SaleController::class, 'create_bill_sales']);
        Route::post('create_bill_sales_pending', [SaleController::class, 'create_bill_sales_pending']);

        Route::resource('inventories', InventoryController::class);
        Route::post('delete_inventory', [InventoryController::class, 'destroy']);
        Route::post('update_inventory', [InventoryController::class, 'update']);

        Route::resource('payment_modes', PaymentModeController::class);
        Route::post('delete_payment_mode', [PaymentModeController::class, 'destroy']);
        Route::post('update_payment_mode', [PaymentModeController::class, 'update']);

        Route::resource('bills', BillController::class);
        Route::post('delete_bill', [BillController::class, 'destroy']);
        Route::post('update_bill', [BillController::class, 'update']);

    });
});







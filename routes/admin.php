<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\ThrottleRequests;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['permission:admin'])->group(function () {
   Route::prefix('admin')->group(function () {
      Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
      Route::get('/users', [App\Http\Controllers\Admin\Users\ListController::class, 'index'])->name('admin.users');
      Route::get('/user/{id}', [App\Http\Controllers\Admin\Users\ManageController::class, 'index'])->name('admin.user.edit');
      Route::post('/user/{id}', [App\Http\Controllers\Admin\Users\ManageController::class, 'update'])->name('admin.edit.user');
      Route::post('/user/{id}/verify', [App\Http\Controllers\Admin\Users\ManageController::class, 'verify'])->name('admin.user.verify');
      Route::post('/user/{id}/password', [App\Http\Controllers\Admin\Users\ManageController::class, 'changePassword'])->name('admin.user.password');
      Route::post('/user/{id}/balance', [App\Http\Controllers\Admin\Users\ManageController::class, 'balance'])->name('admin.user.balance');
      Route::post('/user/{id}/delete', [App\Http\Controllers\Admin\Users\ManageController::class, 'delete'])->name('admin.user.delete');

      Route::get('/invoices', [App\Http\Controllers\Admin\Invoices\ListController::class, 'index'])->name('admin.invoices');

      Route::prefix('settings')->group(function () {
         Route::controller(App\Http\Controllers\Admin\Settings\BaseController::class)->group(function () {
            Route::get('/', 'index')->name('admin.settings');
            Route::patch('/', 'update')->name('admin.settings.update');
         });
      });

      Route::controller(App\Http\Controllers\Admin\Invoices\ManageController::class)->group(function () {
         Route::post('/invoices/new', 'create')->name('admin.invoice.new');
         Route::get('/invoice/{id}', 'index')->name('admin.invoice.edit');
         Route::post('/invoice/{id}', 'update')->name('admin.invoice.update');
         Route::post('/invoice/{id}/item/add', 'createItems')->name('admin.invoice.item.add');
         Route::post('/invoice/{id}/item/delete/{itemid}', 'deleteItems')->name('admin.invoice.item.delete');
      });

      Route::prefix('tickets')->group(function () {
         Route::controller(App\Http\Controllers\Admin\Support\TicketsController::class)->group(function () {
            Route::get('/', 'index')->name('admin.tickets');
         });
         Route::controller(App\Http\Controllers\Admin\Support\TicketController::class)->group(function () {
            Route::get('/{id}', 'index')->name('admin.ticket');
            Route::post('/{id}', 'update')->name('admin.ticket.reply');
            Route::delete('/{id}', 'delete')->name('admin.ticket.delete');
         });
      });

      Route::prefix('pterodactyl')->group(function () {
         Route::prefix('nodes')->group(function () {
            Route::controller(App\Http\Controllers\Admin\Pterodactyl\Nodes\ListController::class)->group(function () {
               Route::get('/', 'index')->name('admin.pterodactyl.nodes');
               Route::post('/', 'store')->name('admin.pterodactyl.nodes.new');
               Route::put('/{id}', 'update')->name('admin.pterodactyl.nodes.edit');
               Route::delete('/{id}', 'delete')->name('admin.pterodactyl.nodes.delete');
            });
         });

         Route::prefix('products')->group(function () {
            Route::controller(App\Http\Controllers\Admin\Pterodactyl\Products\BaseController::class)->group(function () {
               Route::get('/', 'index')->name('admin.pterodactyl.products');
               Route::post('/', 'store')->name('admin.pterodactyl.products.new');
               Route::put('/{id}', 'update')->name('admin.pterodactyl.products.edit');
            });
         });

         Route::prefix('services')->group(function () {
            Route::controller(App\Http\Controllers\Admin\Pterodactyl\Services\ListController::class)->group(function () {
               Route::get('/', 'index')->name('admin.pterodactyl.services');
               Route::delete('/{id}', 'delete')->name('admin.pterodactyl.services.delete');
            });
            Route::controller(App\Http\Controllers\Admin\Pterodactyl\Services\EditController::class)->group(function () {
               Route::get('/edit/{id}', 'index')->name('admin.pterodactyl.services.edit');
               Route::put('/edit/{id}', 'update')->name('admin.pterodactyl.services.save');
               Route::post('/edit/{id}/power/{signal}', 'power')->name('admin.pterodactyl.services.power');
            });
         });

         Route::prefix('logs')->group(function () {
            Route::controller(App\Http\Controllers\Admin\Pterodactyl\Logs\ListController::class)->group(function () {
               Route::get('/', 'index')->name('admin.pterodactyl.logs');
               Route::delete('/delete/{id}', 'delete')->name('admin.pterodactyl.logs.delete');
            });
            Route::controller(App\Http\Controllers\Admin\Pterodactyl\Logs\ViewController::class)->group(function () {
               Route::get('/{id}', 'index')->name('admin.pterodactyl.logs.view');
            });
         });
      });
   });
});
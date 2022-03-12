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

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'render'])->name('home');

Route::get('/invoices', [App\Http\Controllers\Invoices\ListController::class, 'render'])->name('invoices');
Route::get('/invoice/{id}', [App\Http\Controllers\Invoices\ViewController::class, 'render'])->name('invoice.view');
Route::get('/invoice/{id}/result', [App\Http\Controllers\Invoices\ResultController::class, 'render'])->name('invoice.result');
Route::post('/invoice/{id}/paypal', [App\Http\Controllers\Invoices\PayController::class, 'paypal'])->name('invoice.pay.paypal');
Route::post('/invoice/{id}/stripe', [App\Http\Controllers\Invoices\PayController::class, 'stripe'])->name('invoice.pay.stripe');
Route::post('/invoice/{id}/balance', [App\Http\Controllers\Invoices\PayController::class, 'balance'])->name('invoice.pay.balance');

Route::get('/services/game', [App\Http\Controllers\Services\Game\ListController::class, 'render'])->name('services.game');
Route::get('/service/game/{id}', [App\Http\Controllers\Services\Game\ManageController::class, 'render'])->name('service.game.manage');
Route::post('/service/game/{id}/renew', [App\Http\Controllers\Services\Game\ManageController::class, 'renew'])->name('service.game.renew');

Route::get('/order/game/{id}', [App\Http\Controllers\Checkout\Game\CheckoutController::class, 'render'])->name('checkout.game');
Route::post('/order/game/{id}', [App\Http\Controllers\Checkout\Game\CheckoutController::class, 'store'])->name('checkout.game.order');

Route::get('/tickets', [App\Http\Controllers\Support\ListController::class, 'render'])->name('tickets');
Route::get('/ticket/{id}', [App\Http\Controllers\Support\ViewController::class, 'render'])->name('ticket');
Route::patch('/ticket/{id}', [App\Http\Controllers\Support\ViewController::class, 'update'])->name('ticket.update');
Route::delete('/ticket/{id}', [App\Http\Controllers\Support\ViewController::class, 'delete'])->name('ticket.close');
Route::get('/tickets/new', function(){
   return view('support.ticket.new');
})->middleware('auth')->name('ticket.new');
Route::post('/tickets/new', [App\Http\Controllers\Support\ViewController::class, 'create'])->name('ticket.open');

Route::get('/logout', function(){
   Auth::logout();
   return Redirect::to(route('login'));
});
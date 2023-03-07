<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});//

//homepages
Route::get('/',function(){
    return redirect()->route('admin-dashboard');
});

//dashboard
Route::prefix('dashboard')
->middleware(['auth:sanctum','admin'])
->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard');

});
//midtrans
Route::get('midtrans/success',[MidtransController::class,'success']);
Route::get('midtrans/unfinish',[MidtransController::class,'unfinish']);
Route::get('midtrans/error',[MidtransController::class,'error']);
 

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



// // Homepage
// Route::get('/', function () {
//     return redirect()->route('admin-dashboard');
// });

// // Dashboard
// Route::prefix('dashboard')
//     ->middleware(['auth:sanctum','admin'])
//     ->group(function() {
//         Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard');
//         Route::resource('food', FoodController::class);
//         Route::resource('users', UserController::class);

//         Route::get('transactions/{id}/status/{status}', [TransactionController::class, 'changeStatus'])->name('transactions.changeStatus');
//         Route::resource('transactions', TransactionController::class);
//     });

// // Midtrans Related
// Route::get('midtrans/success', [MidtransController::class, 'success']);
// Route::get('midtrans/unfinish', [MidtransController::class, 'unfinish']);
// Route::get('midtrans/error', [MidtransController::class, 'error']);


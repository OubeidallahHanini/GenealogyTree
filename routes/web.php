<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/propositions/submit', 'PropositionController@submit')->name('propositions.submit');
Route::post('/propositions/{id}/approve', 'PropositionController@approve')->name('propositions.approve');
Route::post('/propositions/{id}/reject', 'PropositionController@reject')->name('propositions.reject');
Route::post('/propositions/{id}/respond', 'PropositionController@respondToProposition')->name('propositions.respond');


require __DIR__.'/auth.php';

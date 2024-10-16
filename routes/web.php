<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AsyncController;
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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [MatchController::class, 'top']);
Route::post('/top', [MatchController::class, 'top_submit']);

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//}

//admin
Route::middleware(['auth', 'can:admin'])->group(function() {
});

//representative
Route::middleware(['auth', 'can:represetative'])->group(function() {
});

//headcoach
Route::middleware(['auth', 'can:headcoach'])->group(function() {

    //user
    Route::get('/user', [MatchController::class, 'user']);
    Route::post('/user', [MatchController::class, 'user_submit']);

    //newuser
    Route::get('/newuser', [MatchController::class, 'newuser']);
    Route::post('/newuser', [MatchController::class, 'newuser_submit']);
});

//coach
Route::middleware(['auth', 'can:coach'])->group(function() {
    //TOP
    Route::get('/index_coach', [MatchController::class, 'index_coach']);

    //individual_results
    Route::get('/individual_results', [ResultController::class, 'individual_results']);

    //club
    Route::get('/club', [MatchController::class, 'club']);
    Route::post('/club', [MatchController::class, 'club_submit']);

    //newclub
    Route::get('/newclub', [MatchController::class, 'newclub']);
    Route::post('/newclub', [MatchController::class, 'newclub_submit']);

    //match_edit
    Route::get('/match_edit', [MatchController::class, 'match_edit']);
    Route::post('/match_edit', [MatchController::class, 'match_submit']);

    //newmatch
    Route::get('/newmatch', [MatchController::class, 'newmatch']);
    Route::post('/newmatch', [MatchController::class, 'newmatch_submit']);

    //copy_match
    Route::get('/copy_match', [MatchController::class, 'copy_match']);
    Route::post('/copy_match', [MatchController::class, 'copy_match_submit']);

    //match_contents
    Route::get('/match_contents', [MatchController::class, 'match_contents']);
    Route::post('/match_contents', [MatchController::class, 'match_contents_submit']);

    //home_members
    Route::get('/home_members', [MatchController::class, 'home_members']);
    Route::post('/home_members', [MatchController::class, 'home_members_submit']);

    //away_members
    Route::get('/away_members', [MatchController::class, 'away_members']);
    Route::post('/away_members', [MatchController::class, 'away_members_submit']);

    //async
    Route::get('/match_start', [AsyncController::class, 'match_start']);
    Route::get('/match_end', [AsyncController::class, 'match_end']);
    Route::get('/match_pause', [AsyncController::class, 'match_pause']);
    Route::get('/score_display', [AsyncController::class, 'score_display']);
    Route::get('/score_submit', [AsyncController::class, 'score_submit']);
    Route::get('/foul_display', [AsyncController::class, 'foul_display']);
    Route::get('/foul_submit', [AsyncController::class, 'foul_submit']);
    Route::post('/change_submit', [AsyncController::class, 'change_submit']);
    Route::get('/playingtime_insert', [AsyncController::class, 'playingtime_insert']);

});

//user
Route::middleware(['auth', 'can:user'])->group(function() {

    //TOP
    Route::get('/index', [MatchController::class, 'index']);

    //match_results
    Route::get('/match_results', [ResultController::class, 'match_results']);

    //match
    Route::get('/match', [MatchController::class, 'match']);

});

require __DIR__.'/auth.php';

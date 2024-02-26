<?php

use App\Models\Post;
use App\Services\Cache\CacheLayer;
use App\Services\Cache\Contract\CacheContract;
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
//    $user = \App\Models\User::first();
////    $code = (string)rand(100000, 999999);
////    $user->verification_code = encrypt($code);
//    $user->verification_code = null;
//    $user->save();
//    $x = Post::whereDate('deleted_at', '<=', now()->subDays(30)->format('Y-m-d'))
//        ->onlyTrashed()
////        ->get();
//        ->forceDelete();
//    dd($x);
    echo  date('Y-m-d');
});

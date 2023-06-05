<?php

use App\Orchid\Screens\PostEditScreen;
use App\Orchid\Screens\PostListScreen;
use App\Orchid\Screens\TaskScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

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

Route::screen('posts', PostListScreen::class)
    ->name('platform.post.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Posts');
    });

Route::screen('post/{post?}', PostEditScreen::class)
    ->name('platform.post.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.post.list')
            ->push('Edit post');
    });

Route::get('/', function () {
    return view('welcome');
});

Route::screen('task', TaskScreen::class)
    ->name('platform.task')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Task');
    });

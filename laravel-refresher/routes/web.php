<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ],
];



//for static/simple pages
// Route::view('/', 'home.index')->name('home.index');
// Route::view('/contact', 'home.contact')->name('home.contact');

Route::get('/', [HomeController::class, 'home'])->name('home.contact');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

Route::get('/posts/{id}', function ($id) use ($posts) {
    abort_if(!isset($posts[$id]) , 404); 
    return view('posts.show', ['post' => $posts[$id]]);
})


// ->where([
//     'id' => '[0-9]+'
// ])
->name('posts.show');

//optional parameter using ?
Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'Showing ' . $daysAgo . ' posts';
})->name('posts.recent.index')->middleware('auth');


Route::get('/posts', function() use ($posts){
  //  dd(request()->all());
  //dd((int)request()->input('page', 1));
  //dd((int)request()->query('page', 1));
    return view('posts.index', ['posts' => $posts]);
})->name('posts.index');

Route::prefix('/fun')->name('fun.')->group(function() use($posts) {
    Route::get('responses', function() use ($posts){
        return response($posts, 201)
        ->header('Content-Type', 'application/json')
        ->cookie('MY_COOKIE', 'testing testing', 3600);
    })->name('responses');
    
    Route::get('redirect', function() {
        return redirect('/contact');
    })->name('redirect');
    
    Route::get('back', function() {
        return back();
    })->name('back');
    
    Route::get('named-route', function() {
        return redirect()->route('posts.show', ['id' =>1]);
    })->name('named-route');
    
    Route::get('away', function() {
        return redirect()->away('http://google.com');
    })->name('away');
    
    Route::get('json', function() use ($posts) {
        return response()->json($posts);
    })->name('json');
    
    Route::get('download', function()  {
        return response()->download(public_path('/download_me.webp'), 'people');
    })->name('download');
    
});







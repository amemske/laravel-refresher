<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostsController;

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

$posts2 = [
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

Route::get('/', [HomeController::class, 'home'])->name('home.contact');//to get the controller name you can use the class constant
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/single', AboutController::class)->name('home.about'); //single action controlle has no need for methods since it uses invoke

Route::resource('posts', PostsController::class);
//->only(['index', 'show'])



// Route::get('/posts/{id}', function ($id) use ($posts) {
//     abort_if(!isset($posts[$id]) , 404); 
//     return view('posts.show', ['post' => $posts[$id]]);
// })


// // ->where([
// //     'id' => '[0-9]+'
// // ])
// ->name('posts.show');

// //optional parameter using ?
// Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
//     return 'Showing ' . $daysAgo . ' posts';
// })->name('posts.recent.index')->middleware('auth');

//getting the request object
// Route::get('/posts', function() use ($posts){
//    dd(request()->all());
//    dd((int)request()->input('page', 1)); //get individual item..returns a string so you cast it to int
//    dd((int)request()->query('page', 1));
//     return view('posts.index', ['posts' => $posts]);
// })->name('posts.index');



//grouped routes can have same url prefix, same name prefix or same middleware prefix
Route::prefix('/fun')->name('fun.')->group(function() use($posts2) {


    //use response helper when you need to set headers, set cookies or change the response status code, you can also add a view
    Route::get('responses', function() use ($posts2){
        return response($posts2, 201) //response accepts - content, status,response headers
        ->header('Content-Type', 'application/json')
        ->cookie('MY_COOKIE', 'testing testing', 3600); //remember me example
    })->name('responses');


    //redirect can be used when storing data sent to a form, or deleting from db and you need to redirect after the action is successful
    Route::get('redirect', function() {
        return redirect('/contact');
    })->name('redirect');
    
    //back helper redirects to the last address
    Route::get('back', function() {
        return back();
    })->name('back');
    
    //redirect to a specific route using its name
    Route::get('named-route', function() {
        return redirect()->route('posts.show', ['id' =>1]);
    })->name('named-route');
    
    //redirect away from your site
    Route::get('away', function() {
        return redirect()->away('http://google.com');
    })->name('away');
    
    //returning a json easily
    Route::get('json', function() use ($posts2) {
        return response()->json($posts2);
    })->name('json');
    
    //downloading a file using response helper function
    Route::get('download', function()  {
        return response()->download(public_path('/download_me.webp'), 'people'); //the second optional argument is the name you want the user to see if it is different from the original
    })->name('download');
    
});







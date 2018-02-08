<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/clear-cache', function () {
        Cache::flush();
        admin_toastr('Cache temizlendi.');
        return redirect()->back();
    });

    $router->resource('/categories', 'CategoryController');
    $router->resource('/contents', 'ContentController');
    $router->resource('/pages', 'PageController');
    $router->resource('/comments', 'CommentController');


    $router->prefix('api')->group(function () use ($router) {
        $router->get('category/list', 'ApiController@categories');
    });

});

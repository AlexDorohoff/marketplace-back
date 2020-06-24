<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/test', function (\Illuminate\Http\Request $request) use ($router) {
    return $request->all();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'LoginController@login');
    $router->post('/login/refresh', 'LoginController@refresh');
    $router->post('/register', 'RegistrationController@register');
    $router->get('/register/validate/{id}', 'RegistrationController@validated');

    $router->get('/teachers', 'TeacherController@list');
    $router->get('/teachers/{id}', 'TeacherController@show');

    $router->get('/courses', 'CourseController@list');
    $router->get('/courses/{id}', 'CourseController@show');

    $router->get('/documents', 'DocumentController@list'); 
    $router->get('/documents/{id}', 'DocumentController@show'); 

    $router->get('/tags', 'TagController@list');
    $router->get('/tags/{id}', 'TagController@show');
//временно и без авторизации
    $router->get('/purchase', 'PurchaseStatusController@list');

    $router->get('/category', 'CategoryController@list');
    $router->get('/category/{id}', 'CategoryController@show');
    $router->get('/category/course/{id}', 'CategoryController@getByCourseId');
    $router->get('/category/teacher/{id}', 'CategoryController@getByTeacherId');

    $router->get('/document/user', 'DocumentController@getByUser');

});

$router->group(['prefix' => 'api', 'middleware' => 'client'], function () use ($router) {
    $router->get('/profile', 'ProfileController@show'); 
    $router->put('/profile', 'ProfileController@update'); 
    $router->post('/profile/image', 'ProfileController@updateImage'); 
    $router->put('/profile/tag/{id}', 'ProfileController@addTag'); 
    $router->delete('/profile/tag/{id}', 'ProfileController@removeTag'); 

    $router->post('/courses', 'CourseController@create'); 
    $router->put('/courses/{id}', 'CourseController@update'); 
    $router->delete('/courses/{id}', 'CourseController@delete'); 
    $router->post('/courses/{id}/image', 'CourseController@updateImage'); 
    $router->put('/courses/{id}/tag/{tag_id}', 'CourseController@addTag'); 
    $router->delete('/courses/{id}/tag/{tag_id}', 'CourseController@removeTag'); 

    $router->post('/tags', 'TagController@create'); 
    $router->put('/tags/{id}', 'TagController@update'); 
    $router->delete('/tags/{id}', 'TagController@delete'); 

    $router->post('/documents', 'DocumentController@create'); 
    $router->put('/documents/{id}', 'DocumentController@update'); 
    $router->delete('/documents/{id}', 'DocumentController@delete'); 

    $router->get('/requests', 'RequestController@list'); 
    $router->get('/requests/{id}', 'RequestController@show'); 
    $router->post('/requests', 'RequestController@create'); 
    $router->put('/requests/{id}', 'RequestController@update'); 
    $router->put('/requests/{id}/approve', 'RequestController@approve'); 
    $router->delete('/requests/{id}', 'RequestController@delete');
});

$router->group(['prefix' => 'api', 'middleware' => ['client', 'administrative']], function () use ($router) {
    $router->post('/users',  'UserController@create');
    $router->get('/users', 'UserController@list');
    $router->get('/users/{id}', 'UserController@show'); 
    $router->put('/users/{id}', 'UserController@update'); 
    $router->put('/users/{id}/image', 'UserController@updateImage'); 
    $router->delete('/users/{id}', 'UserController@delete');
});


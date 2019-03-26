<?php

Route::group(['namespace' => 'uisits\blackboardintegration\Http\Controllers', 'middleware' => ['web']], function(){
    //Route::get('hello', 'BlackboardintegrationController@index');
    Route::get('hello', 'BlackboardintegrationController@index');
});

?>
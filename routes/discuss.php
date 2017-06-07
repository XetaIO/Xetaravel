<?php

/*
|--------------------------------------------------------------------------
| Discuss Routes
|--------------------------------------------------------------------------
*/
Route::group([
        'namespace' => 'Discuss',
        'prefix' => 'discuss',
        'middleware' => ['permission:access.site,allowGuest']
], function () {
});

<?php
Route::any('/laravelphpdatatble_tag/{datatable}/{filter}/{search}',
		'\Phpdt\Ldt\BaseController@tag',
		function ($datatable,$filter,$search) {})->name('datatable_tagfilter');

Route::any('/laravelphpdatatble_autocomplete/{datatable}/{filter}/{search}',
		'\Phpdt\Ldt\BaseController@autocomplete',
		function ($datatable,$filter,$search) {})->name('datatable_autocompletefilter');

Route::any('/laravelphpdatatble',
		'\Phpdt\Ldt\BaseController@index',
		function ($datatable,$filter,$search) {})->name('datatable_homepage');

Route::any('/laravelphpdatatble_ajaxload',
		'\Phpdt\Ldt\BaseController@ajaxload',
		function ($datatable,$filter,$search) {})->name('datatable_ajaxload');




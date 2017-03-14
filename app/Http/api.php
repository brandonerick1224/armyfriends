<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/docs', 'DocsController@index');

/**
 * Auth
 */
Route::post('/user/register', 'UserController@register');
Route::post('/user/login', 'UserController@login');
Route::post('/user/forgot', 'UserController@forgot');

/**
 * Authenticated area
 */
Route::group(['middleware' => 'auth:api'], function () {

    /**
     * Users
     */
    Route::post('/user/logout', 'UserController@logout');
    Route::post('/user/my-info', 'UserController@myInfo');
    Route::post('/user/my-guests', 'UserController@myGuests');
    Route::post('/user/user-info', 'UserController@userInfo');
    Route::post('/user/update-profile', 'UserController@updateProfile');
    Route::post('/user/search', 'UserController@search');

    /**
     * Messages
     */
    Route::post('/message/chats', 'MessageController@chats');
    Route::post('/message/chat', 'MessageController@chat');
    Route::post('/message/send', 'MessageController@send');
    
    /**
     * Friends
     */
    Route::post('/friend/list', 'FriendController@friends');
    Route::post('/friend/request', 'FriendController@request');
    Route::post('/friend/accept', 'FriendController@accept');
    Route::post('/friend/refuse', 'FriendController@refuse');
    Route::post('/friend/remove', 'FriendController@remove');
    Route::post('/friend/search', 'FriendController@search');

    /**
     * Albums
     */
    Route::post('/album/list', 'AlbumController@albums');
    Route::post('/album/create', 'AlbumController@create');
    Route::post('/album/update', 'AlbumController@update');
    Route::post('/album/remove', 'AlbumController@remove');

    /**
     * Album items
     */
    Route::post('/album_item/list', 'AlbumItemsController@items');
    Route::post('/album_item/show', 'AlbumItemsController@show');
    Route::post('/album_item/upload', 'AlbumItemsController@upload');
    Route::post('/album_item/update', 'AlbumItemsController@update');
    Route::post('/album_item/remove', 'AlbumItemsController@remove');
    Route::post('/album_item/as_profile', 'AlbumItemsController@asProfile');
    Route::post('/album_item/tag', 'AlbumItemsController@tag');
    Route::post('/album_item/untag', 'AlbumItemsController@untag');
    
    /**
     * Notifications
     */
    Route::post('/notification/status', 'NotificationController@status');
    Route::post('/notification/list', 'NotificationController@notifications');

    /**
     * Posts
     */
    Route::post('/post/list', 'PostController@posts');
    Route::post('/post/show', 'PostController@show');
    Route::post('/post/create', 'PostController@create');
    Route::post('/post/update', 'PostController@update');
    Route::post('/post/remove', 'PostController@remove');

    /**
     * Comments
     */
    Route::post('/comment/list', 'CommentController@comments');
    Route::post('/comment/create', 'CommentController@create');
    Route::post('/comment/update', 'CommentController@update');
    Route::post('/comment/remove', 'CommentController@remove');

    /**
     * Likes
     */
    Route::post('/like/list', 'LikeController@likes');
    Route::post('/like/like', 'LikeController@like');
    Route::post('/like/unlike', 'LikeController@unlike');

    /**
     * Groups
     */
    Route::post('/group/my', 'GroupController@my');
    Route::post('/group/search', 'GroupController@search');
    Route::post('/group/show', 'GroupController@show');
    Route::post('/group/create', 'GroupController@create');
    Route::post('/group/update', 'GroupController@update');
    Route::post('/group/remove', 'GroupController@remove');
    Route::post('/group/join', 'GroupController@join');
    Route::post('/group/leave', 'GroupController@leave');
    Route::post('/group/invite', 'GroupController@invite');

    /**
     * Group users
     */
    Route::post('/group_user/approve', 'GroupUserController@approve');
    Route::post('/group_user/decline', 'GroupUserController@decline');
    Route::post('/group_user/cancel', 'GroupUserController@cancel');
    Route::post('/group_user/accept', 'GroupUserController@accept');
    Route::post('/group_user/refuse', 'GroupUserController@refuse');
    Route::post('/group_user/update', 'GroupUserController@update');
    Route::post('/group_user/remove', 'GroupUserController@remove');

});

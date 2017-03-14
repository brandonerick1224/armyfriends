<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/**
 * Front page
 */
Route::get('/', 'FrontController@index');

/**
 * Auth routes
 */
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::auth();

/**
 * Other
 */
Route::get('/locale/change', 'LocaleController@change');

/**
 * Authenticated area
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index');
    Route::get('/notifications', 'NotificationsController@index');
    Route::get('/guests', 'GuestsController@index');
    Route::get('/video-chat', 'VideoChatController@index');

    Route::get('/profile/{user}', 'ProfileController@index'); // View other users profile

    Route::get('/friends', 'FriendsController@index');
    Route::get('/friends/request/{user}', 'FriendsController@request');
    Route::get('/friends/accept/{user}', 'FriendsController@accept');
    Route::get('/friends/refuse/{user}', 'FriendsController@refuse');
    Route::get('/friends/remove/{user}', 'FriendsController@remove');
    Route::post('/friends/search', 'FriendsController@search');

    Route::get('/search', 'SearchController@search');

    Route::get('/posts/view/{post}', 'PostsController@view');
    Route::post('/posts/store', 'PostsController@store');
    Route::get('/posts/edit/{post}', 'PostsController@edit');
    Route::post('/posts/update/{post}', 'PostsController@update');
    Route::get('/posts/remove/{post}', 'PostsController@remove');

    Route::get('/comments', 'CommentsController@index');
    Route::get('/comments/load/{type}/{objectId}/{lastId}', 'CommentsController@load');
    Route::post('/comments/add/{type}/{id}', 'CommentsController@add');
    Route::get('/comments/remove/{comment}', 'CommentsController@remove');
    Route::post('/comments/update/{comment}', 'CommentsController@update');

    Route::get('/likes/like/{type}/{id}', 'LikesController@like');
    Route::get('/likes/unlike/{type}/{id}', 'LikesController@unlike');
    Route::get('/likes/likes/{type}/{id}', 'LikesController@likes');

    Route::get('/messages', 'MessagesController@index');
    Route::get('/messages/message/{user}', 'MessagesController@message');
    Route::post('/messages/send/{user}', 'MessagesController@send');
    Route::get('/messages/chat/{user}', 'MessagesController@chat');
    Route::post('/messages/poll', 'MessagesController@poll');

    Route::get('/settings', 'SettingsController@index');
    Route::post('/settings/update', 'SettingsController@update');

    Route::get('/albums', 'AlbumsController@index');
    Route::get('/albums/view/{album}', 'AlbumsController@view');
    Route::get('/albums/create', 'AlbumsController@create');
    Route::post('/albums/store', 'AlbumsController@store');
    Route::get('/albums/edit/{album}', 'AlbumsController@edit');
    Route::post('/albums/update/{album}', 'AlbumsController@update');
    Route::get('/albums/remove/{album}', 'AlbumsController@remove');
    Route::get('/albums/upload/{album}', 'AlbumsController@upload');
    Route::get('/albums/{user}', 'AlbumsController@index');

    Route::get('/album_items/view/{album_item}', 'AlbumItemsController@view');
    Route::post('/album_items/upload/{album}', 'AlbumItemsController@upload');
    Route::post('/album_items/update/{album_item}', 'AlbumItemsController@update');
    Route::get('/album_items/remove/{album_item}', 'AlbumItemsController@remove');
    Route::get('/album_items/as-profile/{album_item}', 'AlbumItemsController@asProfile');

    Route::post('/user_tag/tag/{album_item}', 'UserTagController@tag'); // Tag user on album item
    Route::get('/user_tag/untag/{user_tag}', 'UserTagController@untag'); // Untag user
    Route::get('/user_tag/users', 'UserTagController@users'); // Untag user

    Route::get('/groups', 'GroupsController@index');
    Route::post('/groups/search', 'GroupsController@search');
    Route::get('/groups/view/{group}', 'GroupsController@view');
    Route::get('/groups/create', 'GroupsController@create');
    Route::post('/groups/store', 'GroupsController@store');
    Route::get('/groups/edit/{group}', 'GroupsController@edit');
    Route::post('/groups/update/{group}', 'GroupsController@update');
    Route::get('/groups/remove/{group}', 'GroupsController@remove');
    Route::get('/groups/join/{group}', 'GroupsController@join');
    Route::get('/groups/leave/{group}', 'GroupsController@leave');
    Route::get('/groups/invite/{group}', 'GroupsController@invite'); // Invite users to group
    Route::post('/groups/invite/{group}', 'GroupsController@postInvite'); // Send invitation

    Route::get('/group_user/approve/{group_user}', 'GroupUserController@approve'); // Approve invitation
    Route::get('/group_user/decline/{group_user}', 'GroupUserController@decline'); // Refuse invitation
    Route::get('/group_user/cancel/{group_user}', 'GroupUserController@cancel'); // Cancel invitation
    Route::get('/group_user/accept/{group_user}', 'GroupUserController@accept'); // Accept invitation
    Route::get('/group_user/refuse/{group_user}', 'GroupUserController@refuse'); // Refuse invitation
    Route::get('/group_user/edit/{group_user}', 'GroupUserController@edit'); // Edit group user
    Route::post('/group_user/update/{group_user}', 'GroupUserController@update'); // Update group user
    Route::get('/group_user/remove/{group_user}', 'GroupUserController@remove'); // Update group user
});

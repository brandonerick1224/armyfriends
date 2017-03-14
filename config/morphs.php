<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Morph maps
    |--------------------------------------------------------------------------
    |
    | Morph maps describes possible relationship for morph models
    |
    */


    'commentable' => [
        'posts'       => \App\Models\Post::class,
        'album_items' => \App\Models\AlbumItem::class,
    ],

    'likeable' => [
        'user_profiles' => \App\Models\UserProfile::class,
        'posts'         => \App\Models\Post::class,
        'album_items'   => \App\Models\AlbumItem::class,
    ],

    'notificable' => [
        'comments'      => \App\Models\Comment::class,
        'friends'       => \App\Models\Friend::class,
        'group_user'    => \App\Models\GroupUser::class,
        'likes'         => \App\Models\Like::class,
        'messages'      => \App\Models\Message::class,
        'user_profiles' => \App\Models\UserProfile::class,
        'user_tags'     => \App\Models\UserTag::class,
    ],
    
    'subscribable' => [
        'posts'       => \App\Models\Post::class,
        'album_items' => \App\Models\AlbumItem::class,
    ],
    
    'viwable' => [
        'user_profiles' => \App\Models\UserProfile::class,
    ],

];

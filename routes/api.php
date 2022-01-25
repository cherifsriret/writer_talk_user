<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [\App\Http\Controllers\ApiControllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\ApiControllers\AuthController::class, 'login']);
Route::post('buy-package', [\App\Http\Controllers\ApiControllers\UserController::class, 'buy_package'])->middleware('auth:sanctum');
Route::get('/accept-payment/{id}',[\App\Http\Controllers\ApiControllers\UserController::class,'accept_payment']);
Route::get('/cancel-payment/{id}',[\App\Http\Controllers\ApiControllers\UserController::class,'cancel_payment']);
Route::group(['middleware' => ['auth:sanctum','check_trail']], function () {

    Route::get('/user', function(Request $request) {
        return auth()->user();
    });
    Route::post('change-password', [\App\Http\Controllers\ApiControllers\UserController::class,'change_password']);
//    Route::get('user', [\App\Http\Controllers\ApiControllers\AuthController::class, 'user']);
    Route::post('submit-user-post', [\App\Http\Controllers\ApiControllers\PostController::class, 'submit_user_post']);
    Route::post('get-user-posts', [\App\Http\Controllers\ApiControllers\PostController::class,'get_user_posts']);
    Route::post('cancel-user-subscription', [\App\Http\Controllers\ApiControllers\PostController::class,'cancel_user_subscriptions']);
    Route::post('get-user-search', [\App\Http\Controllers\ApiControllers\PostController::class,'get_user_search']);

    Route::post('submit-user-story', [\App\Http\Controllers\ApiControllers\PostController::class,'submit_user_story']);
    Route::get('get-user-stories', [\App\Http\Controllers\ApiControllers\PostController::class,'get_user_stories']);

    Route::post('submit-user-hightlight', [\App\Http\Controllers\ApiControllers\PostController::class,'submit_user_highlight']);
    Route::get('get-user-hightlights', [\App\Http\Controllers\ApiControllers\PostController::class,'get_user_hightlights']);
    Route::get('get-sidebar-highlights', [\App\Http\Controllers\ApiControllers\PostController::class,'get_sidebar_hightlights']);
//    Route::get('get-sidebar-highlights', [\App\Http\Controllers\ApiControllers\PostController::class,'get_sidebar_hightlights']);
    Route::post('add-highlight-ratings',[\App\Http\Controllers\ApiControllers\PostController::class,'add_highlight_ratings']);
    Route::post('get-genre-highlights',[\App\Http\Controllers\ApiControllers\PostController::class,'get_genre_highlights']);

    Route::post('get-user-by-contact',[\App\Http\Controllers\ApiControllers\UserController::class,'get_user_by_contact']);
    Route::get('get-top-writers',[\App\Http\Controllers\ApiControllers\UserController::class,'get_top_writers']);
    Route::post('update-show-top-hundered', [\App\Http\Controllers\ApiControllers\UserController::class,'update_show_top_hundered']);

    Route::post('save-user-commment', [\App\Http\Controllers\ApiControllers\PostController::class,'save_user_comment']);
    Route::post('user-comment-reply', [\App\Http\Controllers\ApiControllers\PostController::class,'user_comment_reply']);
    Route::post('get-post-comments', [\App\Http\Controllers\ApiControllers\PostController::class,'get_post_comments']);
    Route::post('save-user-like', [\App\Http\Controllers\ApiControllers\PostController::class,'save_user_like']);



    Route::post('save-highlight-comment',[\App\Http\Controllers\ApiControllers\PostController::class,'save_highlight_comment']);
    Route::post('get-highlight-comments', [\App\Http\Controllers\ApiControllers\PostController::class,'get_highlight_comments']);

//    Route::post('get-admin-posts', [\App\Http\Controllers\ApiControllers\PostController::class,'get_admin_posts']);

    Route::post('update-profile', [\App\Http\Controllers\ApiControllers\UserController::class, 'update_profile']);
    Route::post('update-profile-image', [\App\Http\Controllers\ApiControllers\UserController::class, 'update_profile_picture']);

    Route::post('get-admin-posts', [\App\Http\Controllers\ApiControllers\PostController::class,'get_admin_posts']);

    Route::post('user-add-penpal',[\App\Http\Controllers\ApiControllers\UserController::class, 'user_add_penpal']);
    Route::post('user-profile-data',[\App\Http\Controllers\ApiControllers\UserController::class, 'user_profile_data']);

    Route::post('user-chat',[\App\Http\Controllers\ApiControllers\UserController::class, 'user_chat']);
    Route::get('get-user-chats',[\App\Http\Controllers\ApiControllers\UserController::class, 'get_user_chats']);
    Route::post('get-user-chat-messages',[\App\Http\Controllers\ApiControllers\UserController::class, 'get_user_chat_messages']);

    Route::post('create-group',[App\Http\Controllers\ApiControllers\GroupChatController::class,'create_group']);
    Route::get('get-user-groups',[App\Http\Controllers\ApiControllers\GroupChatController::class,'get_user_groups']);
    Route::post('store-message',[App\Http\Controllers\ApiControllers\GroupChatController::class,'store_message']);
    Route::post('get-group-messages',[App\Http\Controllers\ApiControllers\GroupChatController::class,'get_group_messages']);

    Route::post('get-user-favourites',[\App\Http\Controllers\ApiControllers\PostController::class, 'get_user_favourites']);
    Route::post('get-tags',[\App\Http\Controllers\ApiControllers\PostController::class, 'get_tags']);


    Route::post('get-user-penpals', [\App\Http\Controllers\ApiControllers\UserController::class,'get_user_penpals']);
    Route::post('update-penpal-status', [\App\Http\Controllers\ApiControllers\UserController::class,'update_penpal_status']);
    Route::post('send-promo-code',[\App\Http\Controllers\ApiControllers\UserController::class, 'send_promo_code']);
    Route::post('store-referral-code',[\App\Http\Controllers\ApiControllers\UserController::class, 'store_referral_code']);
    Route::post('get-penpal-requests',[\App\Http\Controllers\ApiControllers\UserController::class, 'get_penpal_requests']);

    Route::get('get-genres',[\App\Http\Controllers\ApiControllers\PostController::class,'get_genres']);
    Route::post('upload-quick',[\App\Http\Controllers\ApiControllers\PostController::class,'upload_quick']);
    Route::get('get-quicks',[\App\Http\Controllers\ApiControllers\PostController::class,'get_quicks']);
    Route::post('get-quicks-filtered',[\App\Http\Controllers\ApiControllers\PostController::class,'get_quicks_filtered']);
    Route::post('logout', [\App\Http\Controllers\ApiControllers\AuthController::class, 'logout']);
});

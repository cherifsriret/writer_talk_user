<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[\App\Http\Controllers\HomeController::class,'main_screen'])->name('main_screen');

//Route::get('/', function () {
////    return view('welcome');
//    return redirect('/login');
//});

Auth::routes();
Route::get('/profile/{id?}', [App\Http\Controllers\ProfileController::class, 'user_profile'])->name('userProfile');

Route::group(['middleware' => ['auth:sanctum','checkUserTrial_new']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('/change-password',[\App\Http\Controllers\ProfileController::class,'change_password'])->name('userChangePassword');
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'user_settings'])->name('userSetting');
    Route::get('/edit-profile', [App\Http\Controllers\ProfileController::class, 'edit_user_profile'])->name('editUserProfile');
    Route::post('/update-profile', [App\Http\Controllers\ProfileController::class, 'update_user_profile'])->name('updateUserProfile');
    Route::get('/get-explore-user-stories', [App\Http\Controllers\ProfileController::class, 'get_explore_user_stories'])->name('getExploreUserStories');
    Route::get('/get-user-chats', [App\Http\Controllers\ProfileController::class, 'get_user_chats'])->name('getUserChats');
    Route::get('/post-details/{type}/{uuid}', [App\Http\Controllers\ProfileController::class, 'post_details'])->name('postDetails');
    Route::get('/get-user-penpals', [App\Http\Controllers\ProfileController::class, 'get_user_penpals'])->name('getUserPenpals');
    Route::get('/change-password', [App\Http\Controllers\ProfileController::class, 'get_change_user_password'])->name('changeUserPassword');
    Route::get('/friend-requests', [App\Http\Controllers\ProfileController::class, 'get_friend_requests'])->name('friendRequests');
    Route::get('/stories', [App\Http\Controllers\ProfileController::class, 'stories'])->name('stories');
    Route::get('/penpals', [App\Http\Controllers\ProfileController::class, 'penpals'])->name('penpals');
    Route::get('/logout', [App\Http\Controllers\ProfileController::class, 'logout_user'])->name('logout');
    Route::get('/archive-prompts', [\App\Http\Controllers\PostController::class,'get_archive_prompts'])->name('getArchivePrompts');

    Route::get('chat-soc', function (){
       return view('chat_soc');
    });
    Route::post('/submit-post',[\App\Http\Controllers\PostController::class,'submit_post'])->name('submitUserPost');
//    Route::get('/post-details/{id?}',[\App\Http\Controllers\PostController::class,'post_details'])->name('getPostDetails');
    Route::post('/save-post-like',[\App\Http\Controllers\PostController::class,'save_post_like'])->name('savePostLike');
    Route::post('/save-admin-pro-post-like',[\App\Http\Controllers\PostController::class,'save_admin_pro_post_like'])->name('saveAdminPostLike');
    Route::post('/share-post-story',[\App\Http\Controllers\PostController::class,'share_post_story'])->name('sharePostStory');
    Route::get('/get-user-stories',[\App\Http\Controllers\PostController::class,'get_user_stories'])->name('getUserStories');
    Route::get('/find-writers',[\App\Http\Controllers\UserController::class,'find_writers'])->name('userFindPenpals');
    Route::post('/add-penpal',[\App\Http\Controllers\UserController::class, 'user_add_penpal'])->name('userAddPenpal');
    Route::post('/user-penpals', [\App\Http\Controllers\UserController::class,'get_auth_user_penpals'])->name('userPenpals');
    Route::get('/admin-posts/{tag?}', [\App\Http\Controllers\PostController::class,'admin_post'])->name('getAdminPosts');
    Route::get('/get-user-favourites',[\App\Http\Controllers\PostController::class, 'get_user_favourites'])->name('getUserFavourites');
    Route::post('/get-user-favourites',[\App\Http\Controllers\PostController::class, 'get_user_favourites'])->name('getUserFavourites');

    Route::post('create_user-chat',[\App\Http\Controllers\UserController::class, 'create_user_chat'])->name('createUserChat');


    Route::post('get-user-chat-messages',[\App\Http\Controllers\UserController::class, 'get_user_chat_messages']);
    Route::post('create-group',[App\Http\Controllers\UserController::class,'create_group'])->name('userCreateGroup');
    Route::post('get-group-messages',[App\Http\Controllers\UserController::class,'get_group_messages'])->name('userGetGroupMessages');
    Route::post('store-message',[App\Http\Controllers\UserController::class,'store_message']);

    Route::post('/save-user-commment', [\App\Http\Controllers\PostController::class,'save_user_comment'])->name('saveUserComment');
    Route::get('/get_post_latest_comment/{post_id}',[\App\Http\Controllers\PostController::class,'get_post_latest_comment'])->name('getPostLatestComment');
    Route::get('/get_post_comments/{post_id}',[\App\Http\Controllers\PostController::class,'get_post_comments'])->name('getPostComments');
    Route::get('/get_comment_user/{id}',[\App\Http\Controllers\PostController::class,'get_comment_user'])->name('getCommentUserData');
    Route::post('/save-user-commment-reply', [\App\Http\Controllers\PostController::class,'save_user_comment_reply'])->name('saveUserCommentReply');

    Route::post('submit-user-hightlight', [\App\Http\Controllers\PostController::class,'submit_user_highlight'])->name('submitUserHighlight');
    Route::get('get-user-hightlights', [\App\Http\Controllers\PostController::class,'get_user_hightlights'])->name('getUserHighlights');
    Route::post('/search-home-input',[\App\Http\Controllers\HomeController::class,'search_home_input'])->name('userSearchHomeInput');
    Route::post('update-penpal-status', [\App\Http\Controllers\ProfileController::class,'update_penpal_status']);
    Route::post('get_user_hightlights', [\App\Http\Controllers\ProfileController::class,'get_user_hightlights']);
    Route::post('get_genre_highlights', [\App\Http\Controllers\ProfileController::class,'get_genre_highlights']);
    Route::post('filter-admin-posts', [\App\Http\Controllers\ProfileController::class,'filter_admin_posts']);
    Route::post('get_highlight_data', [\App\Http\Controllers\ProfileController::class,'get_highlight_data']);
    Route::post('save-highlight-comment',[\App\Http\Controllers\ProfileController::class,'save_highlight_comment']);
    Route::post('get-highlight-comments', [\App\Http\Controllers\ProfileController::class,'get_highlight_comments']);

    //routes copy from API
    Route::post('create-group-new',[\App\Http\Controllers\ProfileController::class,'create_group_new'])->name('create_group_new');
      // Route::post('get-user-chat-messages',[\App\Http\Controllers\ProfileController::class, 'get_user_chat_messages'])->session_name('getUserChatMessages');
    Route::post('/get-chats',[\App\Http\Controllers\ProfileController::class,'get_data']);
    Route::post('/send-user-message',[\App\Http\Controllers\ProfileController::class,'send_message_user']);
    Route::post('/write-new-message',[\App\Http\Controllers\ProfileController::class,'write_new_message']);
    Route::get('prompt',[\App\Http\Controllers\PostController::class,'Prompt'])->name('prompts');
    Route::post('fetch-prompt',[\App\Http\Controllers\PostController::class,'get_prompt_data']);
    Route::post('/search-tag',[\App\Http\Controllers\PostController::class,'Search_tag']);
    Route::post('/upload-quick',[\App\Http\Controllers\PostController::class,'upload_quick']);
    Route::get('/get-Quick-data',[\App\Http\Controllers\PostController::class,'getQuickdata']);

    // Route::group(['middleware' => ['checkUserTrial_new']], function () {

    // });
});
    Route::post('/buy-package',[\App\Http\Controllers\PaymentApiController::class,'buy_package']);
Route::get('/accept-payment/{id}',[\App\Http\Controllers\PaymentApiController::class,'accept_payment']);
Route::get('/cancel-payment/{id}',[\App\Http\Controllers\PaymentApiController::class,'cancel_payment']);

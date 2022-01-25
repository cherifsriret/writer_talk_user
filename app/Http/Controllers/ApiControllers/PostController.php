<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPost;
use App\Models\AdminPostTag;
use App\Models\AdminTip;
use App\Models\Comment;
use App\Models\Genres;
use App\Models\Highlight;
use App\Models\HighlightGenre;
use App\Models\HighlightHashtag;
use App\Models\HighlightRating;
use App\Models\HighlightView;
use App\Models\Image;
use App\Models\Like;
use App\Models\Penpal;
use App\Models\Post;
use App\Models\Quick;
use App\Models\QuickText;
use App\Models\Story;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserPayment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends BaseController
{
    //

    public function submit_user_post(Request $request){
        $validator = Validator::make($request->all(), [
//            Video / Image / Story
            'file_type'=>'required_with:file',
//            base64 / form-data
            'file_data'=>'required_with:file',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $file = $request->file('file');
        $file_type = $request->input('file_type');
        $file_data = $request->input('file_data');
        $description = $request->input('description');
        if (!$description){
            $description = '';
        }


        if ($file || $description){

            $post_arr = [
                'uuid'=> Str::uuid(),
                'user_id'=> $user->uuid,
                'description'=>$description,
                'suspend'=>0,
                'file_type'=> $file_type,
            ];

            if ($file){

                if ($file_data == 'form-data'){

                    $fileName = 'post_'.rand(999,9999).time() .'.'. strtolower($file->getClientOriginalExtension());

                    if ($file_type == 'video'){

//                        $filePath = $file->move(public_path('uploads/videos'), $fileName);
                        $filePath = $file->storeAs('uploads/videos', $fileName, 'public');


                    }
                    if ($file_type == 'image'){

//                        $filePath = $file->move(public_path('uploads/images'), $fileName);

                        $filePath = $file->storeAs('uploads/images', $fileName, 'public');


                    }

                }
                $post_arr['file'] = $filePath;

            }
            $add_post  = Post::create($post_arr);

            if ($add_post){
                $response = [
                    'success'=> true,
                    'message'=>'Post Submitted Successfully'
                ];
            }else{
                $response = [
                    'success'=> false,
                    'message'=>'Failed to Save Post'
                ];
            }

        }else{
            $response = [
                'success'=> false,
                'message'=>'File or Description is required to upload post'
            ];
        }

            return $response;
    }
    public function upload_quick(Request $request){
        $validator = Validator::make($request->all(), [
            'file_type'=>'required_with:file',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $file = $request->file('file');
        $file_type = $request->input('file_type');

        if ($file){

            $post_arr = [
                'uuid'=> Str::uuid(),
                'user_id'=> $user->uuid,
            ];

            if ($file){

                $fileName = 'quick_'.rand(999,9999).time() .'.'. strtolower($file->getClientOriginalExtension());

                if ($file_type == 'video'){

                    $filePath = $file->storeAs('uploads/videos', $fileName, 'public');
                    $post_arr['file'] = $filePath;

                }



            }
            $add_post  = Quick::create($post_arr);

            if ($add_post){
                $response = [
                    'success'=> true,
                    'message'=>'Quick Submitted Successfully'
                ];
            }else{
                $response = [
                    'success'=> false,
                    'message'=>'Failed to Save Post'
                ];
            }

        }else{
            $response = [
                'success'=> false,
                'message'=>'File or Description is required to upload post'
            ];
        }

            return $response;
    }

    public function get_quicks(){

        $user = Auth::user();
        $posts = [];


        $user_quicks = Quick::query()
            ->orderBy('id','desc')
            ->get();
        if(sizeof($user_quicks) > 0){

            foreach ($user_quicks as $up => $up_row){
                $formated_arr = (object)[];
                $likes_count = Like::query()->where('post_id',$up_row->uuid)->where('post_type',"quick")->count();
                $is_liked = Like::query()->where('post_id',$up_row->uuid)->where('user_id',$user->uuid)->where('post_type',"quick")->first();
                $formated_arr->id = $up_row->id;
                $formated_arr->like = $likes_count;
                $formated_arr->likeStatus = $is_liked ? true : false;
                $formated_arr->post = (object)[
                    'url' => $up_row->file,
                    'uuid' => $up_row->uuid,
                ];
                $user_details = User::query()->where('uuid',$up_row->user_id)->first();
                $user_obj = (object)[
                    'userId' => $user_details->uuid,
                    'name' => $user_details->name,
                ];
                $formated_arr->user = $user_obj;
array_push($posts,$formated_arr);
            }
        }
        $quick_word = QuickText::query()->first();
$response = [
    'success' => true,
    'word' => $quick_word->text,
    'quicks_arr' => $posts,
];
return json_encode($response);
    }
    public function get_quicks_filtered(Request $request){

        $user = Auth::user();
        $posts = [];
    $penpal_name = $request->input('penpal_name');
    $date = $request->input('date');
        $user_quicks = [];
        $users_query = User::query()->where('name','LIKE','%'.$penpal_name.'%')->get();
        if (sizeof($users_query) > 0){
            foreach ($users_query as $user_data){
                $user_q = null;
                if ($date){

                    $user_q = Quick::query()->where('user_id',$user_data->uuid)->whereDate('created_at',Carbon::parse($date))->first();
                }else{
                    $user_q = Quick::query()->where('user_id',$user_data->uuid)->first();
                }
                if ($user_q){
                    array_push($user_quicks, $user_q);
                }
            }
        }
        if(sizeof($user_quicks) > 0){

            foreach ($user_quicks as $up => $up_row){
                $formated_arr = (object)[];
                $likes_count = Like::query()->where('post_id',$up_row->uuid)->where('post_type',"quick")->count();
                $is_liked = Like::query()->where('post_id',$up_row->uuid)->where('user_id',$user->uuid)->where('post_type',"quick")->first();
                $formated_arr->id = $up_row->id;
                $formated_arr->like = $likes_count;
                $formated_arr->likeStatus = $is_liked ? true : false;
                $formated_arr->post = (object)[
                    'url' => $up_row->file,
                    'uuid' => $up_row->uuid,
                ];
                $user_details = User::query()->where('uuid',$up_row->user_id)->first();
                $user_obj = (object)[
                    'userId' => $user_details->uuid,
                    'name' => $user_details->name,
                ];
                $formated_arr->user = $user_obj;
array_push($posts,$formated_arr);
            }
        }
$response = [
    'success' => true,
    'quicks_arr' => $posts,
];
return json_encode($response);
    }
    public function cancel_user_subscriptions(Request $request){
        $user_data = Auth::user();

        if ($user_data){

            $update_data = array(
                'end_date' => Carbon::now()->subDays(1)
            );
            $update_ip = UserPayment::query()
                ->where('user_id',$user_data->uuid)
                ->update($update_data);
if ($update_ip){
    $response = [
        'success'=> true,
        'message'=>'Subscription canceled',
    ];
}else{
    $response = [
        'success'=> false,
        'message'=>"Subsription couldn't update",
    ];
}

        }else{
            $response = [
                'success'=> false,
                'message'=>'User is missing',
            ];
        }
        return json_encode($response);
    }
    public function get_user_posts(Request $request){

        $search = $request->input('search');
        $user = Auth::user();
        $posts = [];
        $penpals = Penpal::query()->where('status','Accept')
                        ->where('sender_id',$user->uuid)
                        ->orWhere('receiver_id', $user->uuid)->get();

        $user_posts = Post::query()
            ->where('user_id', $user->uuid)
            ->where('suspend', 0)
            ->withCount(['likes','comments'])
            ->where('description', 'LIKE', '%'.$search.'%')
            ->orderBy('id','desc')
            ->paginate(10);
        if(sizeof($user_posts) > 0){
            foreach ($user_posts as $up => $up_row){
                array_push($posts,$up_row);
            }
        }

        if (sizeof($penpals) > 0){
            foreach ($penpals as $p => $p_row){
                $toPick = $user->uuid;
                if ($toPick == $p_row->sender_id){
                    $toPick = $p_row->receiver_id;
                }else{
                    $toPick = $p_row->sender_id;
                }
                $penpal_posts = Post::query()
                    ->where('user_id', $toPick)
                    ->where('suspend', 0)
                    ->withCount(['likes','comments'])
                    ->where('description', 'LIKE', '%'.$search.'%')
                    ->orderBy('id','desc')
                    ->get();

                if(sizeof($penpal_posts) > 0){
                    foreach ($penpal_posts as $pp => $pp_row){
                        array_push($posts,$pp_row);
                    }
                }


            }
        }
        if (sizeof($posts)> 0){
            foreach ($posts as $u => $row){
                $like = false;
                $like_exist =  Like::query()->where('user_id', Auth::user()->uuid)->where('post_id', $row->uuid)->first();
                if ($like_exist){
                    $like = true;
                }
                $row['is_like'] = $like;
                if ($row->file){
                    $file_explode = explode('.',$row->file);
                    $row['extension'] = @$file_explode[1];
                }

                $row['formatted_created_at'] = @$row->created_at->diffForHumans();
                $comments = @$row->comments;

                if (sizeof($comments)> 0) {
                    foreach ($comments as $c => $c_row) {

                        $comment_user_data = User::query()->where('uuid', @$c_row->user_id)->first();
                        if ($comment_user_data) {

                            $c_row['comment_user_name'] = @$comment_user_data->name;
                            $c_row['comment_user_image'] = @$comment_user_data->image;
                            $c_row['comment_created_at_formatted'] = @$c_row->created_at->diffForHumans();
                        }

                        $row['comments'] = @$comments;
                    }
                }
                $user = User::query()->select('id','uuid', 'name','email','contact_no','image', 'status','verify_user')
                    ->where('uuid', $row->user_id)->first();
                if ($user){
                    $penpal_counts = Penpal::query()->where('status','Accept')
                        ->where('sender_id',$user->uuid)->orWhere('receiver_id', $user->uuid)->count();
//                    $user['image'] = Image::query()->where('imageable_id',$user->id)->where('imageable_type','App\Models\User')->pluck('url')->first();
                   $user['penpal_counts'] = $penpal_counts;
                    $row['user'] = $user;
                }
            }

        }
        $limit = $request->input('last_limit');
        $post_count = count($posts);
        if ($post_count > $limit){

            $posts = array_slice($posts, 0, $limit);
        }
        $response = [
            'success'=> true,
            'message'=>'Record Found Successfully',
            'user_posts'=>$posts,
            'post_count'=>$post_count
        ];
        return $response;
    }

    public function get_user_search(Request $request){
        $search = $request->input('search');
        $tag = $request->input('tag');
        $user = Auth::user();
        $users = [];
        $posts = [];
        $tags = [];
        if (!empty($search)){
            //        if ($tag == 'writers'){
            $users = User::query()->where('id','!=', $user->id)
                ->where('name','LIKE','%'.$search.'%')->get();
            if (sizeof($users)> 0){
                foreach ($users as $u => $u_row){
                    $penpal =  Penpal::query()->whereIn('sender_id', [Auth::user()->uuid,$u_row->uuid])
                        ->whereIn('receiver_id',[Auth::user()->uuid,$u_row->uuid])->first();
                    if ($penpal){
                        $u_row['request_status'] = $penpal->status;
                    }
                }
            }
//            $response = [
//                'success'=>true,
//                'message'=>'Record found successfully',
//                'data'=> $users
//            ];
//        }

//        if ($tag == 'posts'){
            $posts = Post::query()->where('description','LIKE','%'.$search.'%')->get();
            if (sizeof($posts) > 0){
                foreach ($posts as $p => $p_row){
                    $user =  User::query()->where('uuid', $p_row->user_id)->first();

                    $p_row['user'] = $user;
                }
            }
//            $response = [
//                'success'=>true,
//                'message'=>'Record found successfully',
//                'data'=> $posts
//            ];
//        }

//        if ($tag == 'tags'){
            $tags = Tag::query()->where('tag_name','LIKE','%'.$search.'%')->get();

            $response = [
                'success'=>true,
                'message'=>'Record found successfully',
                'data'=>[
                    'writers'=> $users,
                    'posts'=> $posts,
                    'tags'=>$tags
                ]
            ];
//        }
        }else{
            $response = [
                'success'=>true,
                'message'=>'Record found successfully',
                'data'=>[
                    'writers'=> $users,
                    'posts'=> $posts,
                    'tags'=>$tags
                ]
            ];
        }

        return $response;
    }

    public function get_admin_posts(Request $request){
        $user = Auth::user();
        $basic_post_arr = [];
        $pro_post_arr = [];
        $tag_id = $request->input('tag_id');
        $page = $request->input('page');

        $start_limit= 0;
        $end_limit= 10;
        if (empty($page)){
            $page = 1;
        }
        if ($page != 1){
            $start_limit = (($page - 1) * 10) + 1;
            $end_limit = $page * 10;
        }else{
            $start_limit = ($page - 1) * 10;
            $end_limit = $page * 10;
        }



        $page = $page * 10;
        if ($user){
            if (!empty($tag_id)){
                $post_tags = AdminPostTag::query()->where('tag_id', $tag_id)->get();
                if (sizeof($post_tags) > 0){
                    foreach ($post_tags as $p => $p_row){

                        $admin_basic_post = AdminPost::query()->withCount(['likes','comments'])
                                        ->where('uuid',$p_row->post_id)
                                        ->where('tip_type','basic')
                                        ->orderBy('id','desc')
                                        ->first();
                                if ($admin_basic_post){
                                    array_push($basic_post_arr, $admin_basic_post);
                                }
                        $admin_pro_post = AdminPost::query()->withCount(['likes','comments'])
                                        ->where('tip_type','pro')
                                        ->where('uuid',$p_row->post_id)
                                        ->orderBy('id','desc')
                                        ->first();
                                if ($admin_pro_post){
                                    array_push($pro_post_arr, $admin_pro_post);
                                }
                        }
                    }
                $basic_posts = $basic_post_arr;
                $total_basic_data_count  = count($basic_posts);
                $total_basic = (int)($total_basic_data_count / 10);
                usort($basic_posts,function($a, $b) {
                    return $a['created_at'] < $b['created_at'];
                });
                $basic_posts = array_slice($basic_posts, $start_limit,$end_limit);
                $pro_posts = $pro_post_arr;
                $total_pro_data_count  = count($pro_posts);
                $total_pro = (int)($total_pro_data_count / 10);
                usort($pro_posts,function($a, $b) {
                    return $a['created_at'] < $b['created_at'];
                });
                $pro_posts = array_slice($pro_posts, $start_limit,$end_limit);


            }else{

                $basic_posts = AdminPost::query()->withCount(['likes','comments'])
                    ->where('tip_type','basic')
                    ->orderBy('id','desc')->limit($end_limit,$start_limit)->get();
                $total_basic_data_count = AdminPost::query()->withCount(['likes','comments'])
                    ->where('tip_type','basic')
                    ->orderBy('id','desc')->count();
                $total_basic = (int)($total_basic_data_count / 10);
                $pro_posts = AdminPost::query()->withCount(['likes','comments'])
                    ->where('tip_type','pro')
                    ->orderBy('id','desc')->limit($end_limit,$start_limit)->get();
                $total_pro_data_count = AdminPost::query()->withCount(['likes','comments'])
                    ->where('tip_type','pro')
                    ->orderBy('id','desc')->count();
                $total_pro = (int)($total_pro_data_count / 10);

            }

            if (sizeof($basic_posts)> 0){
                foreach ($basic_posts as $b =>$b_row){

                    $admin_name = Admin::query()->pluck('name')->first();
                    $b_row->post_name = $admin_name;


                    $like_exist =  Like::query()->where('user_id', $user->uuid)->where('post_id', $b_row->uuid)->first();

                    if ($like_exist){
                        $b_row['is_like'] = true;
                    }else{
                        $b_row['is_like'] = false;
                    }
                    if ($b_row->file){

                        $explode_file = explode('.',$b_row->file);
                        $extension = $explode_file[1];
                        $b_row['extension']= $extension;
                    }

                    $format_date = @$b_row->created_at->diffForHumans();
                    $b_row['basic_formatted_date'] = $format_date;
                    $comments = @$b_row->comments;
                    if (sizeof($comments)> 0){
                        foreach ($comments as $c=> $bc_row){

                            $comment_user_data = User::query()->where('uuid', @$bc_row->user_id)->first();
                            if ($comment_user_data) {

                                $bc_row['comment_user_name'] = @$comment_user_data->name;
                                $bc_row['comment_user_image'] = @$comment_user_data->image;
                                $bc_row['comment_created_at_formatted'] = @$bc_row->created_at->diffForHumans();
                            }

                            $b_row['comments'] = @$comments;
                        }
                    }
                }
            }
            if (sizeof($pro_posts)> 0){
                foreach ($pro_posts as $b =>$p_row){
                    $admin_name = Admin::query()->pluck('name')->first();
                    $p_row->post_name = $admin_name;
                    $like_exist =  Like::query()->where('user_id', $user->uuid)->where('post_id', $p_row->uuid)->first();

                    if ($like_exist){
                        $p_row['is_like'] = true;
                    }else{
                        $p_row['is_like'] = false;

                    }
                    if ($p_row->file){

                        $explode_file = explode('.',$p_row->file);
                        $extension = $explode_file[1];
                        $p_row['extension']= $extension;
                    }

                    $format_date = @$p_row->created_at->diffForHumans();
                    $p_row['basic_formatted_date'] = $format_date;
                    $comments = @$p_row->comments;
                    if (sizeof($comments)> 0){
                        foreach ($comments as $c=> $pc_row){

                            $comment_user_data = User::query()->where('uuid', @$pc_row->user_id)->first();
                            if ($comment_user_data) {

                                $pc_row['comment_user_name'] = @$comment_user_data->name;
                                $pc_row['comment_user_image'] = @$comment_user_data->image;
                                $pc_row['comment_created_at_formatted'] = @$pc_row->created_at->diffForHumans();
                            }

                            $p_row['comments'] = @$comments;
                        }
                    }

                }
            }
            $total_rounded_basic = round($total_basic);
            if (!$total_rounded_basic > 0){
                $total_rounded_basic = 1;
            }
            $total_rounded_pro = round($total_pro);
            if (!$total_rounded_pro > 0){
                $total_rounded_pro = 1;
            }
            $response = [
                'success'=> true,
                'message'=>'Record Found',
                'total_basic_pages'=>$total_rounded_basic,
                'total_pro_pages'=>$total_rounded_pro,
                'data'=> [
                    'basic_posts'=>$basic_posts,
                    'pro_posts'=>$pro_posts
                ]
            ];


        }else{
            $response = [
                'success'=> false,
                'message'=> 'User not logged in'
            ];
        }

        return $response;
    }

    public function get_user_favourites(Request $request){
        $public_path = public_path();
        $user = Auth::user();
        $search = $request->input('search');
        $postArr = [];
        if (Auth::user()){
           $user_fav = Like::query()->where('user_id', $user->uuid)->get();
           if (sizeof($user_fav)>0){
               foreach ($user_fav as $u => $row){
                   if ($row->post_type == 'user'){
                     $post_data =  Post::query()->where('uuid', $row->post_id)
                         ->where('description','LIKE', '%'.$search.'%')->first();

                     if ($post_data){
                         $date = $post_data->created_at;
                         $date = Carbon::parse($date);
                         $post_user = User::query()->where('uuid', $post_data->user_id)->first();
                         $post_data['user_name'] = $post_user->name;
                         $post_data['user_image'] = $post_user->image;

                            if ($post_data->file){
                                $explode_file = explode('.',$post_data->file);
                                $extension = $explode_file[1];
                                $post_data['extension']= $extension;
                            }

                         if ($date){

                             $post_data['formatted_created_at'] =$date->diffForHumans(Carbon::now());
                         }
                         array_push($postArr, $post_data);
                     }
                   }
                   if($row->post_type == 'admin'){
                       $post_data =  AdminPost::query()->where('uuid', $row->post_id)->first();
                    if ($post_data){

                        $date = $post_data->created_at;
                        $date = Carbon::parse($date);
                        $post_data['user_name'] = 'Admin';
                        $post_data['user_image'] =  $public_path.'/assets/admin_avatar.png';
                        if ($post_data->file){
                            $explode_file = explode('.',$post_data->file);
                            $extension = $explode_file[1];
                            $post_data['extension']= $extension;
                        }
                        if ($date){

                            $post_data['formatted_created_at'] =$date->diffForHumans(Carbon::now());
                        }
                        array_push($postArr, $post_data);
                    }

                   }
               }
           }
            $response = [
                'success'=> true,
                'message'=> 'Record found successfully',
                'data'=>$postArr,
            ];
        }else{
            $response = [
                'success'=> false,
                'message'=>'You are not logged in'
            ];
        }
        return $response;
    }

    public function get_tags(Request $request){


        $tags = Tag::query()->orderBy('id','asc');
        if ($request->has('search')){
            $tags->where('tag_name','LIKE', '%'.$request->input('search').'%');
        }
        $tags_data = $tags->get();
        $response = [
            'success'=> true,
            'message'=> 'Record found Successfully',
            'data'=>$tags_data
        ];

        return $response;
    }

    public function save_user_comment(Request $request){

            $user = Auth::user();
            $post_id = $request->input('post_id');
            $comment = $request->input('comment');
            $post_type = $request->input('post_type');

            $validator = Validator::make($request->all(), [
                'post_id'=>'required',
                'comment'=>'required',
                'post_type'=>'required',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
                $comment = new Comment;
                $comment->uuid = Str::uuid();
                $comment->comment = $request->comment;
                $comment->post_type = $post_type;

                $comment->user()->associate($request->user());
                if ($post_type == 'user'){

                    $post = Post::where('uuid',$post_id)->first();
                }
                if ($post_type == 'admin'){
                    $post = AdminPost::where('uuid',$post_id)->first();
                }
                $comment->post_id = $post->uuid;
                $post->comments()->save($comment);

//            $created_comment = Comment::create([
//                'uuid'=>Str::uuid(),
//                'user_id'=> $user->uuid,
//                'post_id'=> $post_id,
//                'comment'=> $comment,
//                'post_type'=> $post_type
//            ]);

//            if ($created_comment){
                return response(['success'=> true, 'message'=> 'Comment Saved Successfully']);
//            }else{
//                return response(['success'=> false, 'message'=> 'Failed to save comment ']);
//
//            }
    }

    public function save_highlight_comment(Request $request){

            $user = Auth::user();
            $highlight_id = $request->input('highlight_id');
            $comment = $request->input('comment');
            $comment_type = $request->input('comment_type');
            $post_type = 'user';

            $validator = Validator::make($request->all(), [
                'comment'=>'required',

            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
                $comment = new Comment;
                $comment->uuid = Str::uuid();
                $comment->comment = $request->comment;
                $comment->comment_type = $comment_type;
                $comment->post_type = $post_type;

                $comment->user()->associate($request->user());
                if ($post_type == 'user'){

                    $highlight = Highlight::where('uuid',$highlight_id)->first();
                }

                $comment->post_id = $highlight->uuid;
                $highlight->comments()->save($comment);



//            if ($created_comment){
                return response(['success'=> true, 'message'=> 'Comment Saved Successfully']);
//            }else{
//                return response(['success'=> false, 'message'=> 'Failed to save comment ']);
//
//            }
    }

    public function get_highlight_comments(Request $request){
        $highlight_id = $request->input('highlight_id');
        if (!empty($highlight_id)){
            $is_highlight  = Highlight::query()->where('uuid', $highlight_id)->first();
            if ($is_highlight){
                $is_highlight['praise_comments'] = [];
                $is_highlight['critique_comments'] = [];
                $praise_comments = Comment::query()->where('post_id', $is_highlight->uuid)
                    ->where('commentable_type','App\Models\Highlight')
                    ->where('comment_type','praise')->get();

                $critique_comments = Comment::query()->where('post_id', $is_highlight->uuid)
                    ->where('commentable_type','App\Models\Highlight')
                    ->where('comment_type','critique')->get();

                if (sizeof($praise_comments) > 0){
                    foreach ($praise_comments as $pc => $pc_row){

                        $user = User::query()->where('id', $pc_row->user_id)->first();
                        $pc_row['comment_created_at_formatted'] = Carbon::parse($pc_row->created_at)->format('d/m/Y');
                        $pc_row['user'] = $user;

                    }
                    $is_highlight['praise_comments'] = $praise_comments;
                }

                if (sizeof($critique_comments) > 0){
                    foreach ($critique_comments as $cc => $cc_row){

                       $user = User::query()->where('id', $cc_row->user_id)->first();
                        $cc_row['comment_created_at_formatted'] = Carbon::parse($cc_row->created_at)->format('d/m/Y');
                        $cc_row['user'] = $user;

                    }
                    $is_highlight['critique_comments'] = $critique_comments;
                }

            }else{
                $response = ['success'=> false,'message'=>'No highlight exists with this id'];
            }
            $response = ['success'=>true,'message'=>'Record found','data'=>$is_highlight];

        }else{
            $response = ['success'=>false,'message'=>'Highlight id can\'t be null'];
        }
        return $response;
    }

        public function user_comment_reply(Request $request){
            $user = Auth::user();
            $post_id = $request->input('post_id');
            $comment = $request->input('comment');
            $post_type = $request->input('post_type');
            $comment_id = $request->input('comment_id');

            $validator = Validator::make($request->all(), [
                'post_id'=>'required',
                'comment'=>'required',
                'post_type'=>'required',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $reply = new Comment();
            $reply->uuid = Str::uuid();
            $reply->comment = $comment;
            $reply->post_type = $post_type;

            $reply->user()->associate($request->user());

            $reply->parent_id = $comment_id;
            if ($post_type == 'user'){

                $post = Post::where('uuid',$post_id)->first();
            }

            if ($post_type == 'admin'){
                $post = AdminPost::where('uuid',$post_id)->first();

            }
            $reply->post_id = $post->uuid;

            $post->comments()->save($reply);

            return response(['success'=> true, 'message'=> 'Comment Saved Successfully']);

        }


    public function get_post_comments(Request $request){

        $validator = Validator::make($request->all(), [
            'post_id'=> 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $post_id = $request->input('post_id');

       $comments = Comment::query()->where('post_id', $post_id)
           ->whereNull('parent_id')->get();
        if (sizeof($comments)> 0){
            foreach ($comments as $c => $c_row){
                $user = User::query()->where('id', $c_row->user_id)->first();
                if ($user){

                    $c_row['comment_user_name'] = $user->name;
                    $c_row['comment_user_image'] = $user->image;
                    $c_row['comment_created_at_formatted'] = @$c_row->created_at->diffForHumans();
                }
                   $replies = $c_row->replies;

                if (sizeof($replies) > 0){
                    foreach ($replies as $r => $r_row){
                          $user = User::query()->where('id',$r_row->user_id)->first();
                            if ($user){
                                $r_row['comment_user_name'] = $user->name;
                                $r_row['comment_user_image'] = $user->image;
                                $r_row['comment_created_at_formatted'] = @$c_row->created_at->diffForHumans();
                            }
                    }
                }
                $c_row['replies'] = $replies;

            }
        }
        $response = [
            'success'=>true,
            'message'=>'Record found',
            'data'=>$comments
        ];
        return $response;
    }

    public function save_user_like(Request $request){

        $user = Auth::user();
        $post_id = $request->input('post_id');
        $post_type = $request->input('post_type');

        $validator = Validator::make($request->all(), [
            'post_id'=>'required',
            'post_type'=>'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $is_exist = Like::query()->where('user_id', $user->uuid)->where('post_id' , $post_id)->first();

        if ($is_exist){
            $is_exist->delete();
            return response(['success'=> true, 'message'=> 'Unlike']);

        }else{
            $create_like = Like::create([
                'uuid'=>Str::uuid(),
                'user_id'=> $user->uuid,
                'post_id'=> $post_id,
                'post_type'=> $post_type,
            ]);
            if ($create_like){
                return response(['success'=> true, 'message'=> 'Like']);

            }
        }

    }



    public function submit_user_story(Request $request){
        $user = Auth::user();
        $file = $request->file;
        $description = $request->input('description');
        $file_type = $request->input('file_type');
        $file_data = $request->input('file_data');
        $post_id = $request->input('post_id');
        $post_type = $request->input('post_type');


        $validator = Validator::make($request->all(), [
//            Video / Image / Story
            'file_type'=>'required_with:file',
//            base64 / form-data
            'file_data'=>'required_with:file',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

            if ($file) {

                if ($file_data == 'base64') {

                    $file_64 = $file; //your base64 encoded data

                    $extension = explode('/', explode(':', substr($file_64, 0, strpos($file_64, ';')))[1])[1];   // .jpg .png .pdf

                    $replace = substr($file_64, 0, strpos($file_64, ',') + 1);

// find substring fro replace here eg: data:image/png;base64,

                    $file = str_replace($replace, '', $file_64);

                    $file = str_replace(' ', '+', $file);

                    $fileName = Str::random(10) . '.' . $extension;

//        Storage::disk('public')->put($imageName, base64_decode($image));
                    if ($file_type == 'video') {

                        Storage::put('public/uploads/stories/' . $fileName, base64_decode($file), 'public');

                        Story::create([
                            'uuid' => Str::uuid(),
                            'user_id' => $user->uuid,
                            'file' => 'public/uploads/stories/' . $fileName,
                            'file_type' => $file_type,
                            'post_type'=>$post_type
                        ]);

                    }
                    if ($file_type == 'image') {
                        Storage::put('public/uploads/stories/' . $fileName, base64_decode($file));
//                        $filePath = $file->storeAs('uploads/images', $fileName);
                        Story::create([
                            'uuid' => Str::uuid(),
                            'user_id' => $user->uuid,
                            'file' => 'public/uploads/stories/' . $fileName,
                            'file_type' => $file_type,
                            'post_type'=>$post_type

                        ]);

                    }
                }
                if ($file_data == 'form-data') {

                    $fileName = 'post_'.rand(999,9999).time() .'.'. strtolower($file->getClientOriginalExtension());


                    if ($file_type == 'video') {
                        $video_height = $request->input('video_height');
                        $video_width = $request->input('video_width');
                        $video_x = $request->input('video_x');
                        $video_y = $request->input('video_y');
                        $message = $request->input('message');
                        $text_x = $request->input('text_x');
                        $text_y = $request->input('text_y');


                        $filePath = $file->storeAs('uploads/stories', $fileName, 'public');

                        $add_story = Story::create([
                            'uuid' => Str::uuid(),
                            'user_id' => $user->uuid,
                            'file' => $filePath,
                            'file_type' => $file_type,
                            'post_type'=>$post_type,
                            'video_height'=>$video_height,
                            'video_width'=>$video_width,
                            'video_x'=>$video_x,
                            'video_y'=>$video_y,
                            'message'=>$message,
                            'text_x'=>$text_x,
                            'text_y'=>$text_y
                        ]);
                        if ($add_story){
                            $response = [
                                'success'=> true,
                                'message'=> 'Record added successfully'
                            ];
                        }
                    }
                    if ($file_type == 'image') {
                        $filePath = $file->storeAs('uploads/stories', $fileName, 'public');
                        $add_story = Story::create([
                            'uuid' => Str::uuid(),
                            'user_id' => $user->uuid,
                            'file' => $filePath,
                            'file_type' => $file_type,
                            'post_type'=>$post_type

                        ]);
                        if ($add_story){
                            $response = [
                                'success'=> true,
                                'message'=> 'Record added successfully'
                            ];
                        }
                    }

                }
            }
            if ($post_id){
                if ($post_type == 'user'){
                    $post_exist = Post::query()->where('uuid', $post_id)->first();
                }
                if ($post_type == 'admin'){
                   $post_exist =  AdminPost::query()->where('uuid', $post_id)->first();
                }
                 if ($post_exist){
                     $add_story = Story::create([
                         'uuid'=>Str::uuid(),
                         'user_id'=> $user->uuid,
                         'post_id'=>$post_exist->uuid,
                         'post_type'=>$post_type,
                     ]);
                     if ($add_story){
                         $response = [
                             'success'=> true,
                             'message'=> 'Record added successfully'
                         ];
                     }
                 }else{
                     $response = [
                         'success'=> false,
                         'message'=> 'Requested post not found'
                     ];
                 }
            }
            $response = [
                'success'=> true,
                'message'=>'Post Submitted Successfully'
            ];


        return $response;
    }

    public function get_user_stories(Request $request){
        $user = Auth::user();
        $today_stories = [];
        $user_stories_arr = [];
        $admin_story_data = [];
        $penpal_stories_arr = [];


        $get_auth_user = null;



        $user_stories = Story::query()->where('user_id', $user->uuid)
            ->where('created_at',  '>=', Carbon::now()->subDay()->toDateTimeString())->latest()->get();
        if (sizeof($user_stories)> 0){
            $get_auth_user = User::query()->select('id','uuid','email','name','image','favorite_genres')
                ->where('uuid', $user->uuid)->first();
            foreach ($user_stories as $us=> $u_row){
                if ($u_row->post_id){
                    $post = Post::query()->where('uuid',$u_row->post_id)->first();
                    if ($post){
                       $user =  User::query()->where('uuid', $post->user_id)->first();
                       $post['user'] = $user;
                       $u_row['post'] = $post;
                       $u_row['tip_type'] = 1;
                     }
                }else{
                        $post = Story::query()->where('uuid',$u_row->uuid)->first();
                        if ($post){

                            $user =  User::query()->where('uuid', $u_row->user_id)->first();
                            $post['user'] = $user;
                            $u_row['post'] = $post;
                            $u_row['tip_type'] = 2;
                        }


                }
                array_push($user_stories_arr, $u_row);
            }
            $get_auth_user['stories'] = $user_stories_arr;
        }

        $admin_user = null;
        $admin_stories = AdminTip::query()
            ->where('created_at',  '>=', Carbon::now()->subDay()->toDateTimeString())->get();
        if (sizeof($admin_stories)> 0){
            $admin_user = Admin::query()->first();
            foreach ($admin_stories as $a=> $a_row){
                if ($a_row->post_id){
                    $post = AdminPost::query()->where('uuid',$a_row->post_id)->first();
                    if ($post){
                       $user =  Admin::query()->where('uuid', $post->user_id)->first();
                       $post['user'] = $user;
                        $a_row['post'] = $post;
                       $a_row['tip_type'] = 1;

                     }
                }else{
                    $post = Story::query()->where('uuid',$a_row->uuid)->first();
                    if ($post){
                        $user =  Admin::query()->where('uuid', $post->user_id)->first();
                        $post['user'] = $user;
                        $a_row['post'] = $post;
                        $a_row['tip_type'] = 2;

                    }

                }
                array_push($admin_story_data, $a_row);

            }

            $admin_user['stories'] = $admin_story_data;


        }


        $penpals = Penpal::query()->where('status', 'accept')->where('sender_id', $user->uuid)
            ->orWhere('receiver_id', $user->uuid)->get();
        if (sizeof($penpals)>0){
            foreach ($penpals as $p=> $p_row){
                if ($user->uuid == $p_row->sender_id){
                    $to_pick = $p_row->receiver_id;
                }else{
                    $to_pick = $p_row->sender_id;
                }



                $get_penpal_stories = Story::query()->where('user_id', $to_pick)
                ->where('created_at',  '>=', Carbon::now()->subDay()->toDateTimeString())->get();
                if(sizeof($get_penpal_stories) > 0){
                    $get_user = User::query()->select('id','uuid','email','name','image','favorite_genres')
                        ->where('uuid', $to_pick)->first();
                    foreach ($get_penpal_stories as $pe => $p_row){
                        if ($p_row->post_id){
                            $post = Post::query()->where('uuid',$p_row->post_id)->first();
                            if ($post){
                                $user =  User::query()->where('uuid', $post->user_id)->first();
                                $post['user'] = $user;
                                $p_row['post'] = $post;
                                $p_row['tip_type'] = 1;
                            }
                        }else{
                            $post = Story::query()->where('uuid',$p_row->uuid)->first();
                            if ($post){

                                $user =  User::query()->where('uuid', $p_row->user_id)->first();
                                $post['user'] = $user;
                                $p_row['post'] = $post;
                                $p_row['tip_type'] = 2;
                            }


                        }
                        array_push($penpal_stories_arr, $p_row);
                    }
                    $get_user['stories'] = $penpal_stories_arr;
                    array_push($today_stories, $get_user);
                }

            }
        }

        if (sizeof($today_stories)>0){
            foreach ($today_stories as $t => $t_row){
                if ($t_row->file){
                    $file_url = $t_row->file;
                    $explode_extension = explode('.',$file_url);
                    $t_row['extension'] = $explode_extension[1];
                    $user = User::query()->where('uuid', $t_row->user_id)->first();
                    $t_row['user'] = $user;
                }
            }
        }
//        dd($user_stories, $admin_stories, $today_stories);

             $response = [
                 'success'=> true,
                 'message'=> 'Record found successfully',
                 'data'=> [
                     'admin_tips'=> $admin_user,
                     'penpal_tips'=>$today_stories,
                     'user_tips'=> $get_auth_user
                 ]
             ];
//dd($response);
        return $response;
    }

    public function  submit_user_highlight(Request $request){
        $user = Auth::user();

        $validator =  Validator::make($request->all(),[
            'file' => 'required|mimes:doc,pdf,docx|max:2048',
//            'hashtags'=> 'array|max:2'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $file = $request->file('file');
        $file_image = $request->file('file_image');
        $title = $request->input('title');
        $genres = $request->input('genres_arr');
//        $hashtags = $request->input('hashtags');

        $genres = explode(',',$genres);

        $fileName = 'highlight_docs_'.rand(100,9999) . '.' . $file->getClientOriginalExtension();
        $filePath = $request->file('file')->storeAs('uploads/highlights', $fileName, 'public');
        $fileImageName = 'highlight_img'.rand(100,9999) . '.' . $file_image->getClientOriginalExtension();
        $fileImagePath = $request->file('file_image')->storeAs('uploads/highlights', $fileImageName, 'public');

        $create_highlight =Highlight::create([
            'uuid'=>Str::uuid(),
            'user_id'=>$user->uuid,
            'file'=> $filePath,
            'file_image'=>$fileImagePath,
            'title'=>$title
        ]);
        if($create_highlight){

            if (sizeof($genres) > 0){
                foreach ($genres as $g => $g_row){
                    $genre = Genres::query()->where('genres', $g_row)->first();
                    if ($genre){
                           $add_hashtags = HighlightGenre::create([
                               'uuid'=> Str::uuid(),
                               'highlight_id'=>$create_highlight->uuid,
                               'genre_id'=>$genre->genres,

                            ]);
                    }
                }
            }
            $response = [
                'success'=> true,
                'message'=> 'Highlight saved successfully'
            ];
        }else{
            $response = [
                'success'=> false,
                'message'=> 'Failed to save record'
            ];
        }
        return $response;
    }

    public function get_user_hightlights(Request $request){
        $user = Auth::user();
        $highlights_arr = [];
        $highlights = $user->highlights;
        if (sizeof($highlights)> 0){
            foreach ($highlights as $uh => $uh_row){
                array_push($highlights_arr, $uh_row);
            }
        }
        $user_penpals = Penpal::query()->where('status','Accept')
            ->where('sender_id',$user->uuid)
            ->orWhere('receiver_id',$user->uuid)->get();
        if (sizeof($user_penpals)> 0){
            foreach ($user_penpals as $u=> $u_row){
                $toPick = $user->uuid;
                if ($toPick == $u_row->sender_id){
                    $toPick = $u_row->receiver_id;
                }else{
                    $toPick = $u_row->sender_id;
                }
                $other_user = User::query()->where('uuid', $toPick)->first();
                if ($other_user){

                   $other_user_highlights = Highlight::query()->where('user_id', $other_user->uuid)->get();
                   if (sizeof($other_user_highlights) > 0){
                       foreach ($other_user_highlights  as $oh => $oh_row){
                           array_push($highlights_arr,$oh_row);
                       }
                   }
                }

            }
        }
        if (sizeof($highlights_arr)> 0) {
            foreach ($highlights_arr as $h => $row) {

                $rating = HighlightRating::query()->where('highlight_id', $row->uuid)
                    ->groupBy('highlight_id')->average('rating');
                $row['rating'] = round($rating,'1');
                $row['views'] = $row->views;
                if($row->file){
                    $file = explode('.',$row->file);
                    $row['extension'] = $file[1];
                }
                if($row->file_image){
                    $file_image = explode('.',$row->file_image);
                    $row['image_extension'] = $file_image[1];
                }

            }
        }
        if ($highlights_arr){
            $response = [
                'success'=> true,
                'message'=> 'Record Found',
                'data'=>$highlights_arr
            ];
        } else{
            $response = [
                'success'=> false,
                'message'=> 'Record Not Found'
            ];
        }
        return $response;
        }
    public function get_sidebar_hightlights(Request $request){
        $user = Auth::user();
        $highlights = Highlight::all();
        $most_rated_arr = [];
        $most_viewed_arr = [];
        if (sizeof($highlights)> 0) {
            foreach ($highlights as $h => $row) {

                $rating = HighlightRating::query()->where('highlight_id', $row->uuid)
                    ->groupBy('highlight_id')->average('rating');
                $row['rating'] = round($rating,'1');
                if($row->file){
                    $file = explode('.',$row->file);
                    $row['extension'] = $file[1];
                }
                if($row->file_image){
                    $file_image = explode('.',$row->file_image);
                    $row['image_extension'] = $file_image[1];
                }
                if ($rating){

                    array_push($most_rated_arr, $row);
                }

            }
            $rating = array_column($most_rated_arr, 'rating');
            array_multisort($rating, SORT_DESC, $most_rated_arr);
//           $most_rated_arr =  collect($most_rated_arr)->sortBy('rating')->reverse();
//            usort($most_rated_arr,function ($a,$b){
//                return $a['rating'] > $b['rating'];
//            });
            $most_rated_arr = array_splice($most_rated_arr, 0,6);
        }
        $top_views = Highlight::query()->orderByDesc('views')->take(6)->get();
        if(sizeof($top_views) > 0){
            foreach ($top_views as $t => $t_row){
                if($row->file){
                    $file = explode('.',$t_row->file);
                    $t_row['extension'] = $file[1];
                }
                if($row->file_image){
                    $file_image = explode('.',$t_row->file_image);
                    $t_row['image_extension'] = $file_image[1];
                }
            }
        }
        $most_viewed_arr = $top_views;
        if ($highlights){
            $response = [
                'success'=> true,
                'message'=> 'Record Found',
                'data'=>[
                    'most_rated'=>$most_rated_arr,
                    'most_viewed'=> $most_viewed_arr
                ]
            ];
        } else{
            $response = [
                'success'=> false,
                'message'=> 'Record Not Found'
            ];
        }
        return $response;
        }

    public function add_highlight_view(Request $request){

       $user = Auth::user();
        $highlight_id = $request->input('highlight_id');
       $is_highlight = Highlight::query()->where('uuid', $highlight_id)->first();

       if ($user->status != 'suspend'){
           if ($is_highlight){
                $view_exist = HighlightView::query()->where('user_id',$user->uuid)
                    ->where('highlight_id',$is_highlight->uuid)->first();
                if (!$view_exist){
                    HighlightView::create([
                        'uuid' => Str::uuid(),
                        'ip_address' => $request->ip(),
                        'user_id' => $user->uuid,
                        'highlight_id'=>$is_highlight->uuid,
                        'view'=> 1,
                        'agent'=> $request->header('user-agent'),
                    ]);
                    $inc_highlight_view = $is_highlight->view + 1;
                    $is_highlight->update([
                        'views'=>$inc_highlight_view
                    ]);
                    $response = [
                        'success'=> true,
                        'message'=>'Record added successfully'
                    ];
                }else{
                    $response = [
                        'success'=> false,
                        'message'=>'View by this user already exists'
                    ];
                }

           }else{
               $response = [
                   'success'=> false,
                   'message'=> 'You can\'t rate this right now. Try again later'
               ];
           }

       }else{
           $response = [
             'success'=> false,
             'message'=> 'User is suspended by admin'
           ];
       }

        return $response;
    }

    public function add_highlight_ratings(Request $request){

        $user = Auth::user();
        $highlight_id = $request->input('highlight_id');
        $rating = $request->input('rating');
        $is_highlight = Highlight::query()->where('uuid', $highlight_id)->first();

        if ($user->status != 'suspend'){
            if ($is_highlight){
                $rating_exist = HighlightRating::query()->where('user_id', $user->uuid)
                    ->where('highlight_id',$highlight_id)->first();
                if (!$rating_exist){
                    HighlightRating::create([
                        'uuid' => Str::uuid(),
                        'ip_address' => $request->ip(),
                        'user_id' => $user->uuid,
                        'highlight_id'=>$is_highlight->uuid,
                        'rating'=> $rating,
                        'agent'=> $request->header('user-agent'),
                    ]);
                    $response = [
                        'success'=> true,
                        'message'=>'Record added successfully'
                    ];
                }else{
                    $response = [
                        'success'=> false,
                        'message'=>'Already Rated'
                    ];
                }

            }else{
                $response = [
                    'success'=> false,
                    'message'=> 'You can\'t rate this right now. Try again later'
                ];
            }
        }else{
            $response = [
                'success'=> false,
                'message'=> 'User is suspended by admin'
            ];
        }

        return $response;
    }

    public function get_genres(){
            $genres = Genres::all();
            $response = [
              'success'=> true,
              'message'=>'Record found',
              'data'=>$genres
            ];
            return $response;
    }

    public function get_genre_highlights(Request $request){
        $user = Auth::user();
        $hashtag_id = $request->input('hashtag_id');

        $highlight_arr = [];
        $genre_arr = [];
        if (!empty($hashtag_id)) {

            if ($hashtag_id == "Top"){
                $highlights = Highlight::with('highlight_genres')->get();
                $most_rated_arr = [];
                $most_viewed_arr = [];
                if (sizeof($highlights)> 0) {
                    foreach ($highlights as $h => $row) {

                        $rating = HighlightRating::query()->where('highlight_id', $row->uuid)
                            ->groupBy('highlight_id')->average('rating');
                        $row['rating'] = round($rating,'1');
                        if($row->file){
                            $file = explode('.',$row->file);
                            $row['extension'] = $file[1];
                        }
                        if($row->file_image){
                            $file_image = explode('.',$row->file_image);
                            $row['image_extension'] = $file_image[1];
                        }
                        if ($rating){

                            array_push($most_rated_arr, $row);
                        }

                    }
                    $rating = array_column($most_rated_arr, 'rating');
                    array_multisort($rating, SORT_DESC, $most_rated_arr);
//           $most_rated_arr =  collect($most_rated_arr)->sortBy('rating')->reverse();
//            usort($most_rated_arr,function ($a,$b){
//                return $a['rating'] > $b['rating'];
//            });
//                    $most_rated_arr = array_splice($most_rated_arr, 0,6);
                }
                $top_views = Highlight::query()->orderByDesc('views')->get();
                if(sizeof($top_views) > 0){
                    foreach ($top_views as $t => $t_row){
                        if($row->file){
                            $file = explode('.',$t_row->file);
                            $t_row['extension'] = $file[1];
                        }
                        if($row->file_image){
                            $file_image = explode('.',$t_row->file_image);
                            $t_row['image_extension'] = $file_image[1];
                        }
                    }
                }
                $most_viewed_arr = $top_views;

                $highlight_arr = array_merge($most_rated_arr,$most_viewed_arr->toArray());
            }else{
                $hashtag = Genres::query()->where('genres', $hashtag_id)->first();

                $highlight_hashtags = HighlightGenre::query()->where('genre_id', $hashtag->genres)->get();
                if (sizeof($highlight_hashtags) > 0) {
                    foreach ($highlight_hashtags as $h => $h_row) {

                        $highlight = Highlight::query()->where('uuid', $h_row->highlight_id)->first();


                        if ($highlight){
                            $rating = HighlightRating::query()->where('highlight_id', $highlight->uuid)
                                ->groupBy('highlight_id')->average('rating');
                            $highlight['rating'] = round($rating,'1');
                            $highlight['views'] = $highlight->views;
                            $explode_file = explode('.',$highlight->file);
                            $highlight['extension'] = $explode_file[1];
                            array_push($highlight_arr, $highlight);
                        }
                    }
                }
            }

            $views = array_column($highlight_arr, 'views');
            array_multisort($views, SORT_DESC, $highlight_arr);

        }



        $response = [
            'success'=> true,
            'message'=>'Record found successfully',
            'data'=>$highlight_arr
        ];
        return $response;
    }

}

<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\HighlightRating;
use App\Models\Image;
use App\Models\Penpal;
use App\Models\Post;
use App\Models\PromoCode;
use App\Models\Referral;
use App\Models\ReferralCode;
use App\Models\User;
use App\Models\UserConnection;
use App\Models\UserMessages;
use App\Models\UserPayment;
use App\Models\UserProfileView;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends BaseController
{
    //

    public function user_add_penpal(Request $request){

            $sender_id = $request->input('sender_id');
            $receiver_id = $request->input('receiver_id');
            $status = $request->input('status');

        $validator = Validator::make($request->all(), [
            'sender_id'=>'required',
            'receiver_id'=>'required',
            'status'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $is_penpal = Penpal::query()->where('status','Accept')->whereIn('sender_id', [$sender_id,$receiver_id])
                                ->WhereIn('receiver_id', [$sender_id,$receiver_id])->first();

        $is_sender_id = User::query()->where('uuid', $sender_id)->first();
        $is_receiver_id = User::query()->where('uuid', $receiver_id)->first();

        if ($is_sender_id && $is_receiver_id){

            if (!$is_penpal){
                $penpal = Penpal::create([
                    'uuid'=> Str::uuid(),
                    'sender_id'=> $sender_id,
                    'receiver_id'=>$receiver_id,
                    'status'=> $status
                ]);
                if ($penpal){
                    $response = [
                        'success'=> true,
                        'message'=> 'Request Sent'
                    ];

                }else{
                    $response = [
                        'success'=> false,
                        'message'=> 'Failed to save record',
                    ];
                }
            }else{
                $response = [
                    'success'=> false,
                    'message'=> 'Record already exist',
                ];
            }


        }else{
            $response = [
                'success'=> false,
                'message'=> 'User not found',
            ];
        }

            return $response;

    }

    public function get_user_penpals(Request $request){
        $search = $request->input('search');
        $user = Auth::user();
        $user_penpals = Penpal::query()->where('status','Accept')->where('sender_id', $user->uuid)
            ->orWhere('receiver_id',$user->uuid)
            ->get();
       $to_pick = $user->uuid;
       $penpal_search = [];
       if (sizeof($user_penpals)>0){
           foreach ($user_penpals as $u => $u_row){

               if ($user->uuid == $u_row->sender_id){
                   $to_pick = $u_row->receiver_id;
               }else{
                   $to_pick = $u_row->sender_id;

               }

               $penpal_data = User::query()->where('uuid', $to_pick)->where('name','LIKE', '%'.$search.'%')->first();
               if ($penpal_data){
                   $penpal_data['formatted_created_at'] = $penpal_data->created_at->diffForHumans();
                   $u_row['user'] = $penpal_data;
                   array_push($penpal_search,$u_row );
               }

           }
       }
           if ($penpal_search){
               $response = [
                   'success'=> true,
                   'message'=> 'Record Found Successfully',
                   'data' => $penpal_search,
               ];
           }else{
               $response = [
                   'success'=> false,
                   'message'=>'No record found'
               ];
           }


       return $response;
    }

    public function update_penpal_status(Request $request){
        $user = Auth::user();
        $status = $request->input('status');
        $other_user_id = $request->input('other_user_id');

        $request_exist = Penpal::query()->whereIn('sender_id', [$other_user_id, $user->uuid])
            ->whereIn('receiver_id', [$other_user_id, $user->uuid])->first();
        if ($request_exist){
            if ($status == 'cancel' || $status == 'Cancel'){
                $request_exist->delete();
            }else{
                $request_exist->update([
                    'status'=>$status,
                ]);
            }

            $response = [
                'success'=>true,
                'message'=>'Request status updated'
            ];
        }else{
            $response = [
                'success'=>false,
                'message'=>'No record found'
            ];
        }
return $response;

    }

    public function user_profile_data(Request $request){

        $user = Auth::user();
        $top_user = false;
        $user_id = $request->input('user_id');
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',

        ]);
            $final_data = [];
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($user->uuid == $user_id){
            $is_user = User::query()->with('posts')
                ->with('highlights')
                ->with('stories')
                ->with('likes')
                ->where('uuid', $user_id)->first();
            if ($is_user){
                $highlights = $is_user->highlights;
                if (sizeof($highlights )> 0){
                    foreach ($highlights as $h => $h_row){
                        $rating = HighlightRating::query()->where('highlight_id', $h_row->uuid)
                            ->groupBy('highlight_id')->average('rating');
                        $h_row['rating'] = round($rating,'1');
                    }
                }
                $top_users = User::query()->orderBy('views', 'desc')->take(100)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
                    if (sizeof($top_users) > 0) {
                        foreach ($top_users as $t=> $t_row){
                            if ($t_row->uuid == $is_user->uuid){
                                $top_user = true;
                                $is_user['top_user'] = $top_user;
                            }else{
                                $is_user['top_user'] = $top_user;

                            }
                        }
                    }
                if (sizeof($is_user->highlights) > 0){
                    foreach ($is_user->highlights as $h=> $h_row){
                        if ($h_row->file){
                            $post_file = $h_row->file;
                            $explode_file = explode('.',$post_file);
                            $extension = $explode_file[1];
                            $h_row['extension']= $extension;
                            $h_row['file'] = $post_file;
//                            $h_row['file_type'] = $h_row->file_type;
                        }
                    }
                }
                if (sizeof($is_user->stories) > 0){
                    foreach ($is_user->stories as $s=> $s_row){
                        if (!empty($s_row->post_id)){
                            $post = Post::query()->where('uuid',$s_row->post_id)->first();
                            if ($post->file){

                                $post_file = $post->file;
                                $explode_file = explode('.',$post_file);
                                $extension = $explode_file[1];
                                $s_row['extension']= $extension;
                                $s_row['file'] = $post_file;
                                $s_row['file_type'] = $post->file_type;
                            }
                        }else{

                            $post_file  = $s_row->file;
                            $explode_file = explode('.',$post_file);
                            $extension = $explode_file[1];
                            $s_row['extension']= $extension;
                            $s_row['file'] =$post_file;
                        }
                    }
                }
                    $penpals = Penpal::query()->where('status','Accept')->where('sender_id',$user_id)
                        ->orWhere('receiver_id',$user_id)->get();
                    if (sizeof($penpals)>0){
                        foreach ($penpals as $p => $p_row){
                            $toPick = $user->uuid;
                            if ($toPick == $p_row->sender_id){
                                $toPick = $p_row->receiver_id;
                            }else{
                                $toPick = $p_row->sender_id;
                            }
                          $penpal_user = User::query()->where('uuid', $toPick)->first();
                            $penpals_user_count = Penpal::query()->where('status','Accept')->where('sender_id',$toPick)
                                ->orWhere('receiver_id',$toPick)->count();
                            $penpal_user['penpal_user_count'] = $penpals_user_count;
                            $p_row['penpal_user'] = $penpal_user;
                        }
                    }
                    $is_user['penpals_count'] = count($penpals);
                    $is_user['penpals'] = $penpals;
                    $resposne = [
                        'success'=> true,
                        'message'=> 'Record Found Success fully',
                        'data'=> $is_user,
                        'status'=>'profile',
//                        'top_user'=>$top_user
                    ];
            }
        }else{

            $profile_view_exist = UserProfileView::query()->where('user_id', $user_id)->first();
            if (!$profile_view_exist){

                $add_profile_view = UserProfileView::create([
                    'uuid'=>Str::uuid(),
                    'ip_address'=>$request->ip(),
                    'user_id'=>$user_id,
                    'agent'=> $request->header('user-agent'),
                ]);
                if ($add_profile_view){
                    $user_to_update = User::query()->where('uuid', $user_id)->first();
                    if ($user_to_update){

                        $update_view = $user_to_update->views + 1;
                        $user_to_update->update([
                            'views'=>$update_view
                        ]);
                    }
                }
            }

            $is_penpal = Penpal::query()
                ->whereIn('sender_id', [$user->uuid, $user_id])
                ->whereIn('receiver_id', [$user->uuid, $user_id])
                ->first();

            if ($is_penpal){
                if ($is_penpal->status == 'Accept'){

                    $is_user = User::query()->where('uuid', $user_id)
                        ->with('posts')
                        ->with('highlights')
                        ->with('stories')
                        ->with('likes')
                        ->first();
                    if ($is_user){
                       $highlights = $is_user->highlights;
                       if (sizeof($highlights )> 0){
                           foreach ($highlights as $h => $h_row){
                               $rating = HighlightRating::query()->where('highlight_id', $h_row->uuid)
                                   ->groupBy('highlight_id')->average('rating');
                               $h_row['rating'] = round($rating,'1');
                           }
                       }
                       $penpal_count = Penpal::query()->where('status', 'Accept')->where('sender_id',$user_id)
                            ->orWhere('receiver_id', $user_id)->count();
                       $is_user['penpals_count'] = $penpal_count;
                    }
                    $resposne = [
                        'success'=> true,
                        'message'=> 'Record Found Success fully',
                        'data'=> $is_user,
                        'status' => 'Friends'
                    ];
                }else{
                    $is_user = User::query()->where('uuid', $user_id)
                        ->first();
                    if ($is_user){
                        $penpal_count = Penpal::query()->where('status', 'Accept')->where('sender_id',$user_id)
                            ->orWhere('receiver_id', $user_id)->count();
                        $is_user['penpals_count'] = $penpal_count;
                    }
                    $status = 'Request Sent';
                    if ($is_penpal->receiver_id == $user->uuid) {
                        $status = 'Accept';
                    }
                    $status_button = $status;
                    $resposne = [
                        'success'=> true,
                        'message'=> 'Record Found Success fully',
                        'data'=> $is_user,
                        'status'=>$status_button
                    ];
                }
            }else{
                $is_user = User::query()->where('uuid', $user_id)
                    ->first();
                if ($is_user){
                    $penpal_count = Penpal::query()->where('status', 'Accept')->where('sender_id',$user_id)
                        ->orWhere('receiver_id', $user_id)->count();
                    $is_user['penpals_count'] = $penpal_count;
                }
                $resposne = [
                    'success'=>true,
                    'message'=>'Penpal not found',
                    'data'=>$is_user,
                    'status'=>'Add Friend'
                ];
            }
        }
            return $resposne;
    }

    public function update_profile_picture(Request $request){
        $user = Auth::user();

        $user_img = $request->file('file');
        if ($user_img){

//
//                    $file_64 = $user_img; //your base64 encoded data
//
//                    $extension = explode('/', explode(':', substr($file_64, 0, strpos($file_64, ';')))[1])[1];   // .jpg .png .pdf
//
//                    $replace = substr($file_64, 0, strpos($file_64, ',') + 1);
//
//// find substring fro replace here eg: data:image/png;base64,
//
//                    $file = str_replace($replace, '', $file_64);
//
//                    $file = str_replace(' ', '+', $file);
//
//                    $fileName = Str::random(10) . '.' . $extension;
//
////                   $fileName = time() . '_' . $request->file->getClientOriginalName();
////                    $filePath = $request->file('file')->storeAs('uploads/images', $fileName, 'public');
//////
//                    Storage::put('public/uploads/images/' . $fileName, base64_decode($file));
//
            $fileName = 'user_'.time() . '_' . $user_img->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/users', $fileName, 'public');

            $user_arr['image'] = 'uploads/users/'.$fileName;

        }

        $user->update($user_arr);

        $response = [
          'success'=> true,
          'message'=>'Image update successfully',
          'data'=>$user
        ];
        return $response;
    }

    public function get_user_by_contact(Request $request){
        $contacts = $request->input('contacts');

        $users_arr = [];
        if (sizeof($contacts)> 0){
            $name_exisiting = "";
            foreach ($contacts as $c => $c_row){
                $string = str_replace(' ', '', $c_row['mobile']);
                $string = str_replace('-', '', $string);
                $user = User::query()->where('contact_no','LIKE', '%'.$string.'%')->first();
               if ($user){
                   $is_penpal =  Penpal::query()->whereIn('sender_id',[Auth::user()->uuid,$user->uuid])
                        ->WhereIn('receiver_id',[Auth::user()->uuid,$user->uuid])->first();
                   if ($is_penpal){
                       $user['status'] = $is_penpal->status;
                   }else{
                       $user['status'] = 'Add Friend';

                   }

                   if ($c_row['name'] != $name_exisiting){
                       array_push($users_arr,$user);
                       $name_exisiting = $c_row['name'];
                   }
               }else{
                   $obj = [];
                   $obj['status'] = "invite";
                   $obj['number'] = $c_row['mobile'];
                   $obj['name'] = $c_row['name'];
                   if ($c_row['name'] != $name_exisiting){
                       array_push($users_arr,$obj);
                       $name_exisiting = $c_row['name'];
                   }
               }
            }
        }
        $response = [
            'success'=> true,
            'message'=>'Record found successfully',
            'data'=> $users_arr
        ];
        return $response;
    }

    public function user_chat(Request $request){
            $sender_id = $request->input('sender_id');
            $receiver_id = $request->input('receiver_id');
            $message = $request->input('message');

            $validator = Validator::make($request->all(), [
                'sender_id'=>'required',
                'receiver_id'=>'required',
                'message'=>'required'
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
           $sender_exist = User::query()->where('uuid', $sender_id)->first();
           $receiver_exist = User::query()->where('uuid',$receiver_id)->first();
            if ($sender_exist && $receiver_exist){


                $conn_exist = UserConnection::query()->whereIn('sender_id', [$sender_id, $receiver_id])
                    ->whereIn('receiver_id',[$sender_id, $receiver_id])->first();

                if (!$conn_exist){
                    $connection = UserConnection::create([
                        'uuid'=> Str::uuid(),
                        'sender_id'=>$sender_id,
                        'receiver_id'=>$receiver_id,
                    ]);
                    if ($connection){
                        $message = UserMessages::create([
                            'uuid'=> Str::uuid(),
                            'connection_id'=>$connection->uuid,
                            'sender_id'=>$sender_id,
                            'receiver_id'=>$receiver_id,
                            'message'=>$message,
                        ]);

                        $response = [
                            'success'=> true,
                            'message'=>'Message saved successfully',
                        ];
                    }
                }else{

                    $message = UserMessages::create([
                        'uuid'=> Str::uuid(),
                        'connection_id'=>$conn_exist->uuid,
                        'sender_id'=>$sender_id,
                        'receiver_id'=>$receiver_id,
                        'message'=>$message,
                    ]);
                    $response = [
                        'success'=> true,
                        'message'=>'Message saved successfully',
                    ];
                }
            }else{
                $response = [
                    'success'=> false,
                    'message'=>'Sender or receiver not exists',
                ];
            }
        return $response;
    }

    public function get_user_chats(Request $request){
        $user = Auth::user();
        if ($user){
            $user_conns = UserConnection::query()->where('sender_id', $user->uuid)
                ->orWhere('receiver_id', $user->uuid)->orderBy('id', 'desc')->get();
            if (sizeof($user_conns) > 0){
                foreach ($user_conns  as $u => $row){

                    $last_msg = UserMessages::query()->where('connection_id', $row->uuid)->latest()->first();
                    $msg_count = UserMessages::query()->where('connection_id', $row->uuid)->count();
                    $user_to_pick = $last_msg->receiver_id;
                    if ($last_msg->receiver_id == $user->uuid){
                        $user_to_pick = $last_msg->sender_id;
                    }

                    $last_msg['format_created_at'] = $last_msg->created_at->diffForHumans();
                    $last_msg['format_date'] = Carbon::parse($last_msg->created_at)->format('m/d/Y');
                    $last_msg['user_details'] =  User::query()->where('uuid',$user_to_pick)->first();
                    $row['latest_message'] = $last_msg;
                    $row['message_count'] = $msg_count;
                }

                $response = [
                    'success'=> true,
                    'message'=> $user_conns
                ];
            }else{
                $response = [
                    'success'=>false,
                    'message'=>'No connection exist',
                ];
            }
        }else{
            $response = [
                'success'=> false,
                'message'=>'User not login'
            ];
        }
        return $response;
    }

    public function get_user_chat_messages(Request $request){
        $receiver = $request->input('receiver_id');
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'receiver_id'=>'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

               $user_conn =  UserConnection::query()->whereIn('sender_id', [$user->uuid, $receiver])
                   ->whereIn('receiver_id',[$user->uuid, $receiver])->first();
               if ($user_conn){
                   $messages = UserMessages::query()->where('connection_id', $user_conn->uuid)
                       ->orderBy('id', 'ASC')->get();
                   if (sizeof($messages)> 0){
                       foreach ($messages as $m => $m_row){
                           $user = User::query()->where('uuid', $m_row->sender_id)->first();
                           $m_row['user'] =$user;
                       }
                       $response = [
                           'success'=>true,
                           'message'=>'Conversation found',
                           'data'=> $messages
                       ];
                   }else{
                       $response = [
                           'success'=> false,
                           'message'=>'No Message Found'
                       ];
                   }

               }else{
                   $response = [
                     'success'=>false,
                     'message'=>'No conversation exists'
                   ];
               }

        return $response;
    }

    public function change_password(Request $request){
        $user = Auth::user();
        $curr_pass = $request->input('current_password');
        $new_pass = $request->input('new_password');
        $conf_pass = $request->input('confirm_password');
        $validator = Validator::make($request->all(),[
                'current_password' => 'required',
                'new_password'=>'required',
                'confirm_password'=>'required|same:new_password'
            ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user_exist = User::query()->where('uuid',$user->uuid)->first();
        if ($user_exist){
          $checked =  Hash::check($curr_pass,$user_exist->password);

          if ($checked){
              $update_password = $user_exist->update([
                  'password'=> Hash::make($new_pass),
                  'secret_key'=>encrypt($new_pass)
              ]);
              if ($update_password){
                  $response = [
                      'success'=>true,
                      'message'=>'Record updated Successfully'
                  ];
              }
          }else{
              $response = [
                  'success'=>false,
                  'message'=>'Current password does not match'
              ];
          }
        }else{
            $response = [
                'success'=>false,'message'=>'User not exist'
            ];
        }
        return $response;
    }

    public function update_profile(Request $request){
            $user_id = Auth::user()->uuid;
            $name = $request->input('name');
            $email = $request->input('email');
            $contact_no = $request->input('contact_no');
            $bio = $request->input('bio');
//            $password = $request->input('password');
            $user_img = $request->file('file');
            $fileName = '';

            $validator = Validator::make($request->all(), [
//                'user_id'=>'required',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }

        $user_exist = User::query()->where('uuid', $user_id)->first();

            $user_arr = [
                'name' => $name,
                'email' => $email,
                'contact_no' => $contact_no,
                'bio' => $bio,
                'status' => 'active',
                'verify_user' => 0,
//                'password' => Hash::make($password),
//                'secret_key' => encrypt($password),
            ];
            if ($user_exist){

                if ($user_img){

//
//                    $file_64 = $user_img; //your base64 encoded data
//
//                    $extension = explode('/', explode(':', substr($file_64, 0, strpos($file_64, ';')))[1])[1];   // .jpg .png .pdf
//
//                    $replace = substr($file_64, 0, strpos($file_64, ',') + 1);
//
//// find substring fro replace here eg: data:image/png;base64,
//
//                    $file = str_replace($replace, '', $file_64);
//
//                    $file = str_replace(' ', '+', $file);
//
//                    $fileName = Str::random(10) . '.' . $extension;
//
////                   $fileName = time() . '_' . $request->file->getClientOriginalName();
////                    $filePath = $request->file('file')->storeAs('uploads/images', $fileName, 'public');
//////
//                    Storage::put('public/uploads/images/' . $fileName, base64_decode($file));
//
                $fileName = 'user_'.time() . '_' . $user_img->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads/users', $fileName, 'public');

                $user_arr['image'] = 'uploads/users/'.$fileName;


                }

                $user_exist->update($user_arr);

                $response = [
                    'success'=> true,
                     'message'=>'Record Update Successfully',
                    'user_data'=> $user_exist,
                ];
            }else{
                $response = [
                    'success'=> false,
                    'message'=>'Failed to  update record',
                ];
            }



        return $response;
    }

    public function get_penpal_requests(Request $request){
            $user = Auth::user();
            if ($user){
                $get_requests = Penpal::query()->where('receiver_id',$user->uuid)
                    ->where('status', 'Request Sent')->get();
                if (sizeof($get_requests)> 0){
                    foreach ($get_requests as $g => $g_row){
                        $user = User::query()->where('uuid', $g_row->sender_id)->first();
                        if ($user){

                            $g_row['user_detail'] = $user;
                        }
                    }
                }
                $response = [
                    'success'=>true,
                    'message'=>'Record found',
                    'data' => $get_requests,
                    'request_count'=>count($get_requests)
                ];

            }else{
                $response = [
                    'success'=> false,
                    'message'=>'Login to countinue'
                ];
            }
            return $response;
    }

    public function send_promo_code(Request $request){
        $user = Auth::user();
        $receiver_email = $request->input('email');
        if ($user){
            $promo_code = PromoCode::all()->pluck('promo_code')->random(1)->toArray();

            $details = [

                'title' => $user->name.' send you a promo code for writters talk',
                'body' => 'Here is the promo code '.@$promo_code[0],
                'link'=> 'https://www.google.com.pk/'

            ];

            \Mail::to( $receiver_email)->send(new \App\Mail\SendPromo($details));

            if(Mail::failures()){
                $response = [
                    'success'=> false,
                    'message'=> 'Problem in sending an email. Try again later'
                ];
            }
            $response = [
                'success'=> true,
                'message'=> 'E-mail send successfully'
            ];
        }else{
            $response = [
                'success'=> false,
                'message'=> 'User not logged in'
            ];
        }
            return $response;
    }

    public function store_referral_code(Request $request){
        $add_referral = ReferralCode::create([
            'sender_id'=> Auth::user()->uuid,
            'referral_code'=>$request->input('referral_code')
        ]);
        if ($add_referral){
            $response = [
              'success'=> true,
              'message'=>'Record added successfully'
            ];
        }
        return $response;
    }
        public function get_top_writers(){
            $users = User::query()->orderBy('views','desc')->take(100)->get();

            $response = [
              'success'=> true,
              'message'=> 'Record found Successfully',
              'data'=>$users
            ];
            return $response;
        }
    public function update_show_top_hundered(Request $request){
        $user = Auth::user();
        if ($user ) {
            if ($user->show_top_hundered == 0) {
                $user->show_top_hundered = 1;
                $user->update();
            } else {
                $user->show_top_hundered = 0;
                $user->update();
            }
        }
        $response = [
            'success'=> true,
            'message'=> 'Update successfully',
            'show_top_hundered'=> $user->show_top_hundered
        ];
        return $response;
    }
    public function accept_payment($id = null){
        if ($id){
            $user_id = UserPayment::query()->where('uuid',$id)->pluck('user_id')->first();
            $update_status = UserPayment::query()->where('uuid',$id)->update([
                'status'=>'accept'
            ]);

            $update_promo_used = User::query()->where('uuid', $user_id)->first();
            $update_promo_used->promo_used = 0;

            if ($update_status && $update_promo_used->update()){
                return view('payment_response')->with(['success'=>true,'message'=>'Congargulations! Payment made Successfully. Now you can use Writers Talk App']);
            }else{
                return view('payment_response')->with(['success'=>false,'message'=>'message','Sorry! There is some problem in payment transfer. Try again later']);

            }
        }
    }

    public function cancel_payment($id = null){
        if ($id){
            $update_status = UserPayment::query()->where('uuid',$id)->update([
                'status'=>'cancel'
            ]);
            if ($update_status){
                return view('payment_response')->with('message','Payment Cancelled');
            }
        }
    }
    public function buy_package(Request $request){
        $sender_data = Auth::user();

        $payment =  $request->input('payment');

        $days =  $request->input('days');
        $receiver_data = Admin::query()->where('id',1)->first();

        if ($sender_data){
            $sender_id = $sender_data->uuid;
            $receiver_id = $receiver_data->uuid;

            //........................... paypal ....................................
            $payment_add = $this->addPaymentDetails($sender_id,$payment,$days);
            $response = [
                'success'=>false,
                'message'=>'Some paypal email error occured',
//                'data'=> $payment.'//'.$payment_add.'//'.$receiver_id.'//'.$receiver_data->paypal_email
            ];
            $token = $this->paypalPaymentToken();
           if (@$token->app_id){
               $paypal =$this->paypalPaymentCurl($payment,$payment_add, $receiver_id ,$receiver_data->paypal_email,$token->app_id);
               if (@$paypal->error){
                   $response = [
                       'success'=>false,
                       'message'=>'Some paypal email error occured',
                   ];
               }
               if (@$paypal->paymentExecStatus =='CREATED'){
                   $payment = $this->paymentDetails($payment_add, $paypal->payKey);

                   $response = [
                       'success'=>true,
                       'message'=>'Payment made successfully',
                       'web_view_link'=> 'https://www.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey='.$paypal->payKey
                   ];
                   return $response;
               }
               else{
                   $response = [
                       'success'=>false,
                       'message'=>$receiver_data->paypal_email,
                   ];
                   return $response;
               }
           }

        }else{
            $response = [
                'success'=>false,
                'message'=>'Please login to continue',
            ];
            return $response;

        }
    }

    private function addPaymentDetails($user_id,$payment,$days){
    $user_payment = UserPayment::query()->where('user_id',$user_id)
            ->where('status', 'pending')->latest()->first();
        if (!$user_payment){
            $payment_add = UserPayment::create([
                'uuid' => Str::uuid(),
                'user_id' => $user_id,
                'payment' => $payment,
                'days' => $days,
                'end_date' => Carbon::now()->addDays($days),
                'status' => 'pending',
            ]);
        }else{
            $payment_add = $user_payment;
        }


        return $payment_add['uuid'];
    }


    //    .......................Admin paypal curl request ....................
    private function paypalPaymentToken(){

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api-m.paypal.com/v1/oauth2/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Basic QWJTV09aUjZIRDk5R3plcVozam9GZlpHNUpaN055LXd4TUc1Mi1KWUk5OFVoSWdWMTRVeUhZNlc4TjBUbzUtNWxkb3hvdXBkYmc4c1h2SEw6RU9WdmZ2MHVvNklOMEpselY1aVdOeFpwaF9naHBUMHp1b04yYlRpWWJRdWpNSTBEb2FZY0VRYXJEaHpxMnNnQ3I3bTdpekd4Q2h0RWI1MC0=',
        'Content-Type: application/x-www-form-urlencoded'
    ),
));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }

    }
    //    .......................Admin paypal curl request ....................
    private function paypalPaymentCurl($payment, $id, $receiver_id,$receiver_paypal_email,$app_id){
        $path = base_path();
        $obj_rec = [
            'amount' => $payment,
            'email' =>$receiver_paypal_email
        ];
        $obj_rec = (object)$obj_rec;
        $json  =[
            'actionType' =>'PAY',
            'currencyCode'=>'USD',
            'receiverList'=>[
                'receiver' =>[$obj_rec
                ]
            ],
            'returnUrl'=> 'http://writerstalkadmin.com/api/accept-payment/'.$id,
            'cancelUrl'=> 'http://writerstalkadmin.com/api/cancel-payment/'.$id,
            'requestEnvelope'=>[
                'errorLanguage'=>'en_US',
                'detailLevel'=>'ReturnAll'
            ]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://svcs.paypal.com/AdaptivePayments/Pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "X-PAYPAL-SECURITY-USERID: writerstalkclub_api1.gmail.com",
                "X-PAYPAL-SECURITY-PASSWORD: 37PLW48U3J6WV23Y",
                "X-PAYPAL-SECURITY-SIGNATURE: Ak5NrzjIyJCjladQvy.M5TgY53jOAPYKaJTuXjLmCiJXA4RyuBWN0HJu",
                "X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
                "X-PAYPAL-RESPONSE-DATA-FORMAT: JSON",
                "X-PAYPAL-APPLICATION-ID: $app_id",
                "Accept: application/json",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }

    }

    private function paymentDetails($id,$payKey){

        $update_data = array('pay_key' => $payKey);
        $update_dayment_data = UserPayment::query()
            ->where('uuid',$id)
            ->update($update_data);

    }

}

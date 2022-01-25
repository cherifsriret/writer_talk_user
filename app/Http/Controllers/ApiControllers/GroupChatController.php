<?php

namespace App\Http\Controllers\ApiControllers;

use App\Events\GroupCreated;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupConversation;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GroupChatController extends BaseController
{
    //
    public function create_group(Request $request){

        $validator =  Validator::make($request->all(),[
            'name' => 'required|unique:groups',
            // 'users'=>'required',
            'creator_id'=>'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $creator_id = $request->input('creator_id');
        $group = Group::create([
            'uuid'=>Str::uuid(),
            'name' => $request->input('name'),
            'creator_id'=> $creator_id,
        ]);

         $users_arr = $request->input('users');
//         $users = explode(',',$users_arr[0]);
        if (sizeof($users_arr)> 0){
            foreach ($users_arr as $u => $row){
               
               $user_exist =  User::query()->where('uuid',$row)->first();

               if ($user_exist){
                   GroupUser::create([
                       'uuid'=>Str::uuid(),
                       'group_id'=>$group->uuid,
                       'user_id'=>$user_exist->uuid,
                       'user_type'=>'member'
                   ]);

               }

            }

        }
        $group->users()->attach($creator_id,['uuid'=>Str::uuid(), 'user_type'=>'admin']);

        $response = [
          'success'=> true,
          'message'=>'Group Added Successfully',
        ];
        return $response;
    }

    public function get_user_groups(){
        $user = Auth::user();
        $group_arr = [];
        if ($user){

           $user_groups = GroupUser::query()->where('user_id', $user->uuid)->get();
           if (sizeof($user_groups)>0){
               foreach ($user_groups as $u => $row){
                 $group =  Group::query()->where('uuid', $row->group_id)->first();
                    if ($group){
                        $last_message = GroupConversation::query()->where('group_id', $group->uuid)->latest()->first();
                        $message_count =GroupConversation::query()->where('group_id', $group->uuid)->count();
                        $group->formatted_created_at = $group->created_at->diffForHumans();
                        $group->message_count = $message_count;
                        if ($last_message){
                            $last_message['formatted_created_at'] = $last_message->created_at->diffForHumans();
                            $last_message['format_date'] = Carbon::parse($last_message->created_at)->format('m/d/Y');

                            $group->last_message = $last_message;
                        }
                            array_push($group_arr, $group);

                    }else{
                        $response = [
                            'success'=> false,
                            'message'=>'No group found'
                        ];
                    }
               }
               $group_arr = collect($group_arr)->sortBy('created_at');
               $response = [
                   'success'=> true,
                   'message'=>'Record found successfully',
                   'data'=> $group_arr
               ];
           }else{
               $response = [
                   'success'=> false,
                   'message'=>'No group found'
               ];
           }

        }else{
            $response = [
                'success'=> false,
                'message'=> 'User not logged in'
            ];
        }
        return $response;
    }

    public function store_message(Request $request){
        $firebaseToken_arr = [];
        $group_id = $request->input('group_id');
        $user_uuid = auth()->user()->uuid;
        $conversation = GroupConversation::create([
            'uuid'=>Str::uuid(),
            'message' => $request->input('message'),
            'group_id' => $group_id,
            'user_id' => $user_uuid,
        ]);

        $conversation->load('user');
        $response = [
          'success'=>true,
          'message'=>'Record Saved Successfully',
          'data'=> $conversation->load('user')
        ];

        $group_users = GroupUser::query()->where('group_id',$group_id )
            ->where('user_id','!=', $user_uuid)->get();
        $user = User::query()->where('uuid',$user_uuid)->first();
//        if (sizeof($group_users)> 0){
//            foreach ($group_users as $g => $row){
//
//                $firebaseToken = User::where('uuid', $row->user_id)->pluck('device_token')->first();
//                array_push($firebaseToken_arr, $firebaseToken);
//            }
//        }
////        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
//
//        $SERVER_API_KEY = 'AAAAxCBcttQ:APA91bE6kRMXhJxKXmITswtq-D4MWObEZz2jKe4bSsBjYZJm-oFiyPXtqRRrdGoalNPS-zZ65CFy7fGvQhktEEw9mospukbbx9Ov38r1ZAzPSXIelu8muzqzjWZLxVMPqB9xssseqV-Z';
//
//        $data = [
//            "registration_ids" => $firebaseToken_arr,
//            "notification" => [
//                "title" => @$user->name+' send message',
//                "body" => $request->message,
//            ]
//        ];
//        $dataString = json_encode($data);
//
//        $headers = [
//            'Authorization: key=' . $SERVER_API_KEY,
//            'Content-Type: application/json',
//        ];
//
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
//
////        $response = curl_exec($ch);
//             curl_exec($ch);


        return $response;
    }

    public function get_group_messages(Request $request){
        $group_user_arr = [];
        $group_id = $request->input('group_id');
        $group_exist = Group::query()->where('uuid', $group_id)->first();
        if ($group_exist){
              $group_messages = GroupConversation::query()->where('group_id', $group_id)->get();
              $group_users = GroupUser::query()->where('group_id', $group_id)->get();
            if (sizeof($group_messages)>0){
                  foreach ($group_messages as $g=> $row){

                      $user_details =  User::query()->where('uuid', $row->user_id)->first();
                      $group_user = GroupUser::query()->where('group_id',$group_id)
                          ->where('user_id', $user_details->uuid)->first();
                      $user_details->user_type = $group_user->user_type;
                      $row['user'] = $user_details;
                  }
            }


            if (sizeof($group_users)>0){
                foreach ($group_users as $u=> $u_row){
                    $user_details =  User::query()->where('uuid', $u_row->user_id)->first();
                    $u_row['user'] = $user_details;
                }
            }

            $response = [
                'success'=> true,
                'message'=>'Record Found',
                'group_details'=>$group_exist,
                'group_users'=>$group_users,
                'group_message'=>$group_messages
            ];

        }else{
            $response = [
                'success'=> false,
                'message'=> 'Group not exist'
            ];
        }
        return $response;
    }

}

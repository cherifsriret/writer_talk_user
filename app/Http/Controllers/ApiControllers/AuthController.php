<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Penpal;
use App\Models\PromoCode;
use App\Models\ReferralCode;
use App\Models\User;
use App\Models\UserPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends BaseController
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'contact_no' => 'required',
//            'favorite_genres' => 'required',
//            'type' => 'required',
//            'email' => 'required|email|unique:users',
//            'password' => 'required',
//            'confirm_password' => 'required|same:password',
//        ]);
//
//        if($validator->fails()){
//            return $this->sendError('Validation Error.', $validator->errors());
//        }

        $password = $request->input('password');
        $user_code = $request->input('promo_code');
        $type = $request->input('type');
        $name = $request->input('name');
        $email = $request->input('email');
        $fav_genres = $request->input('favorite_genres');
        $contact_no = $request->input('contact_no');
        $invitation_key = 'inv_'.Str::random(5);
        $pro_codes_arr = [];
        $ref_codes_arr = [];
        $promo_codes = PromoCode::all();
        if (sizeof($promo_codes)> 0){
            foreach ($promo_codes as $p=> $p_row){
                $code = $p_row->promo_code;
                array_push($pro_codes_arr, $code);
            }
        }
        $referral_codes = ReferralCode::all();
        if (sizeof($referral_codes)> 0){
            foreach ($referral_codes as $r=> $r_row){
                $code = $r_row->referral_code;
                array_push($ref_codes_arr, $code);
            }
        }


        $input = [
            'uuid'=>Str::uuid(),
            'name'=>$name,
            'email'=>$email,
            'contact_no'=>$contact_no,
            'favorite_genres'=>$fav_genres,
            'status'=> 'active',
            'verify_user'=> 0,
            'image'=> 'assets/imgs/user_avatar.png',
            'secret_key'=> encrypt($password),
            'password'=> bcrypt($password),
            'invitation_key'=> $invitation_key
        ];



            if (!in_array($user_code,$pro_codes_arr) && !in_array($user_code, $ref_codes_arr) && $user_code){
                return $response = [
                    'success'=> false,
                    'message'=>'The code you entered is not correct',
                ];
            }else{
                $input['promo_code'] = $user_code;
                if (!empty($user_code) && in_array($user_code, $pro_codes_arr)){
                    $input['promo_used']= 1;
                }else{
                    $input['promo_used']= 0;
                }
                if (!empty($user_code) && in_array($user_code, $ref_codes_arr)){
                    $get_referral = ReferralCode::query()->where('referral_code', $user_code)->first();
                    $add_sender_rec = UserPayment::create([
                        'uuid'=>Str::uuid(),
                        'user_id'=>$get_referral->sender_id,
                        'status'=>'trial',
                        'days'=>30,
                    'promo_code' => $user_code,
                        'end_date'=>Carbon::now()->addDays(30)
                    ]);
                    $input['referral_used']= 1;
                }else{
                    $input['referral_used']= 0;
                }


                $user = User::create($input);
                if ($user){
                     if ($user_code) {

                   $promo_check = PromoCode::query()->where('promo_code',$user_code)->pluck('payment_option')->first();
                   if ($promo_check) {
                        User::query()->where('uuid',$user->uuid)->update([
                                'promo_code'=>$user_code,
                                'promo_used'=>1
                            ]);
                       if ($promo_check == "Free for first year") {

                           $add_sender_rec = UserPayment::create([
                               'uuid' => Str::uuid(),
                               'user_id' =>$user->uuid,
                               'status' => 'trial',
                               'days' => 365,
                               'promo_code' => $user_code,
                               'end_date' => Carbon::now()->addYears(1)
                           ]);
                       }
                       elseif ($promo_check == "Free forever") {

                           $add_sender_rec = UserPayment::create([
                               'uuid' => Str::uuid(),
                               'user_id' => $user->uuid,
                               'status' => 'trial',
                               'days' => 365000,
                               'promo_code' => $user_code,
                               'end_date' => Carbon::now()->addYears(1000)
                           ]);
                       }
                       else{
                           $add_sender_rec = UserPayment::create([
                               'uuid' => Str::uuid(),
                               'user_id' => $user->uuid,
                               'status' => 'trial',
                               'days' => 30,
                               'promo_code' => $user_code,
                               'end_date' => Carbon::now()->addDays(3)
                           ]);
                       }
                   }

}else{
    $end_date = "";
                    if($type == "free"){
$end_date = Carbon::now()->addDays(3);
                    }else{
                        $end_date = Carbon::now();
                    }
                    UserPayment::create([
                        'uuid'=>Str::uuid(),
                        'user_id'=> $user->uuid,
                        'payment'=> 0,
                        'status'=> 'trial',
                        'days'=>3,
                        'promo_code' => $user_code,
                        'end_date'=>$end_date
                    ]);
}
                    
                }
                $is_invitation = User::query()->where('invitation_key',$user_code)->first();

                if ($is_invitation){

                    if ($user){
                        Penpal::create([
                            'uuid'=>Str::uuid(),
                            'sender_id'=>$is_invitation->uuid,
                            'receiver_id'=> $user->uuid,
                            'status'=>'Accept'
                        ]);
                    }
                    $response = [
                        'success'=>true,
                        'message'=>'User register successfully.',
                        'user'=>$user,
//                'token'=>$token
                    ];

                }
//        $token =  $user->createToken('writers_talk')->plainTextToken;
                $response = [
                    'success'=>true,
                    'message'=>'User register successfully.',
                    'user'=>$user,
//                'token'=>$token
                ];
            }



        return $response;
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $arr = [];
        $now = Carbon::now();
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email|string',
//            'password' => 'required',
//        ]);
//
//
//        if($validator->fails()){
//            return $this->sendError('Validation Error.', $validator->errors());
//        }
        $payment_monthly = 7.99;
        $payment_yearly =  79.99;
//            $device_token = $request->input('device_token');
        $user = User::where('email', $request->input('email'))->first();


        if ($user){

            if ($user->promo_used == 1){
                $payment_monthly = 1.99;
            }
            $obj = ["duration"=> "Monthly", "days"=>30, "Payment"=>$payment_monthly];
            $obj2 = ["duration"=> "Yearly", "days"=>365, "Payment"=>$payment_yearly];
            array_push($arr, (object)$obj);
            array_push($arr, (object)$obj2);

            $token =  $user->createToken('writers_talk')->plainTextToken;
            $user_payment = UserPayment::query()->where('user_id', $user->uuid)
                ->whereIn('status',['trial', 'accept'])->latest()->first();
            if ($user_payment){
                $start = Carbon::parse($user_payment->end_date);
                $end =  Carbon::parse($now);
                $result = $start->lte($end);
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'status_code'=>500,
                        'message'=>'Buy package to procced further',
                        'user'=>$user,
                        'token'=>$token,
                        'package_details'=> $arr
                    ]);
                }else{
                    if ($user->status == 'active'){


                        if(!Hash::check($request->input('password'), $user->password)){
                            return response([
                                'message'=> 'Password is not correct'
                            ],401);
                        }
                        $response = [
                            'success'=>true,
                            'message'=>'User login successfully.',
                            'user'=>$user,
                            'token'=>$token,
                        ];
                    }else{
                        $response = [
                            'success'=>false,
                            'message'=>'User suspended by admin',
                        ];
                    }
                }
            }else{
                $response = [
                  'success'=> false,
                  'message'=> 'You Package has expired'
                ];
            }

        }else{
            $response = [
                'success'=>false,
                'message'=>'User not found',
            ];
        }



        return $response;
    }


    public function user(){
        $user = Auth::user();
        return $user;
    }

    public function logout(Request $request){
        \auth()->user()->tokens()->delete();
        return response([
           'success'=> true,
           'message'=>'Logout Successfully',
        ]);
    }



}

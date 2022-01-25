<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Genres;
use App\Models\PromoCode;
use App\Models\ReferralCode;
use App\Models\UserPayment;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new user as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect user after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'favorite_genres' => ['required'],
            'country_code' => ['required'],
            'phone' => ['required'],
            'agree_terms' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        $country_code = $data['country_code'];
        $user_code = $data['code'];
        $phone = $data['phone'];
        $pro_codes_arr = [];
        $ref_codes_arr = [];
        $promo_codes = PromoCode::all();
        if (sizeof($promo_codes) > 0) {
            foreach ($promo_codes as $p => $p_row) {
                $code = $p_row->promo_code;
                array_push($pro_codes_arr, $code);
            }
        }
        $referral_codes = ReferralCode::all();
        if (sizeof($referral_codes) > 0) {
            foreach ($referral_codes as $r => $r_row) {
                $code = $r_row->referral_code;
                array_push($ref_codes_arr, $code);
            }
        }
        if (!in_array($user_code, $pro_codes_arr) && !in_array($user_code, $ref_codes_arr) && $user_code) {
            return $response = [
                'success' => false,
                'message' => 'The code you entered is not correct',
            ];
        } else {
            $input['promo_code'] = $user_code;
            if (!empty($user_code) && in_array($user_code, $pro_codes_arr)) {
                $input['promo_used'] = 1;

              } else {
                $input['promo_used'] = 0;
            }
            if (!empty($user_code) && in_array($user_code, $ref_codes_arr)) {
                $get_referral = ReferralCode::query()->where('referral_code', $user_code)->first();
                $add_sender_rec = UserPayment::create([
                    'uuid' => Str::uuid(),
                    'user_id' => $get_referral->sender_id,
                    'status' => 'trial',
                    'days' => 30,
                    'promo_code' => $user_code,
                    'end_date' => Carbon::now()->addDays(30)
                ]);
                $input['referral_used'] = 1;
            } else {
                $input['referral_used'] = 0;
            }

            $user = User::create([
                'uuid'=> Str::uuid(),
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'secret_key' => encrypt($data['password']),
                'verify_user' => 0,
                'status' => 'active',
                'country_code' => $country_code,
                'image'=> 'assets/imgs/user_avatar.png',
                'contact_no' => $country_code . $phone,
                'favourite_genres' => $data['favorite_genres'],
            ]);

            if ($user){
 if ($user_code) {

                   $promo_check = PromoCode::query()->where('promo_code',$user_code)->pluck('payment_option')->first();
                   if ($promo_check) {
                        User::query()->where('uuid',$user['uuid'])->update([
                                'promo_code'=>$user_code,
                                'promo_used'=>1
                            ]);
                   }
                     if ($promo_check == "Free for first year") {
                      
 $add_sender_rec = UserPayment::create([
                    'uuid' => Str::uuid(),
                    'user_id' => $user['uuid'],
                    'status' => 'trial',
                    'days' => 365,
                    'promo_code' => $user_code,
                    'end_date' => Carbon::now()->addYears(1)
                ]);
                     }
                     if ($promo_check == "Free forever") {
                       
 $add_sender_rec = UserPayment::create([
                    'uuid' => Str::uuid(),
                    'user_id' => $user['uuid'],
                    'status' => 'trial',
                    'days' => 365000,
                    'promo_code' => $user_code,
                    'end_date' => Carbon::now()->addYears(1000)
                ]);
                     }
}else{
     UserPayment::create([
                    'uuid'=>Str::uuid(),
                    'user_id'=> $user->uuid,
                    'payment'=> 0,
                    'status'=> 'trial',
                    'days'=>3,
                    'promo_code' => $user_code,
                    'end_date'=>Carbon::now()->addDays(3)
                ]);
}


               
            }
        }
        return $user;
    }

    public function showRegistrationForm()
    {
        $genres = Genres::all();

        return view('auth.register', compact('genres'));
    }
}

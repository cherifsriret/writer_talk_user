<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserPayment;
use App\Models\PromoCode;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkUSerTrialNew
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user){
            $user_rec = UserPayment::query()->where('user_id', $user->uuid)->first();
            $now = Carbon::now();
//            $payment_monthly = 7.99;
//            $payment_yearly =  79.99;
                $payment_monthly = 4.99;
                $payment_yearly = 49.99;
                $days_month = 30;

                if ($user->referral_used == 1){
                    $payment_monthly = 1.99;
                    $days_month = 30;
                }
                    if($user->promo_used == 1){
                     $promo_check = PromoCode::query()->where('promo_code',$user_rec->promo_code)->pluck('payment_option')->first();
                     if ($promo_check == "$1.99 for first month") {
                        $payment_monthly = 1.99;
                         $days_month = 30;
                     }
                     if ($promo_check == "$1.99 for two months") {
                        $payment_yearly = 1.99;
                         $days_month = 60;
                     }
                     if ($promo_check == "$1.99 for first year") {
                        $payment_yearly = 1.99;
                     }
                     
                   
                }

            $user_payment = UserPayment::query()->where('user_id', $user->uuid)
                ->whereIn('status',['trial', 'accept'])->latest()->first();
            if ($user_payment){
                $start = Carbon::parse($user_payment->end_date);
                $end =  Carbon::parse($now);
                $result = $start->lte($end);

                if ($result){
                    $arr = [];
                    $obj = ["duration"=> "Monthly", "days"=>$days_month, "Payment"=>$payment_monthly];
                    $obj2 = ["duration"=> "Yearly", "days"=>365, "Payment"=>$payment_yearly];
                    array_push($arr, (object)$obj);
                    array_push($arr, (object)$obj2);

                    return  response()->view('packages',compact('arr'));
                 
                }else{
                    return $next($request);
                }
            }

        }else{
            return redirect('login');
        }


    }
}

<?php
namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Models\Bill;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class CustomerBillController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->getAuth();
    }

    public function getAuth(){
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid'],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired'],401);
            }else{
                return response()->json(['status' => 'Authorization Token not found'],401);
            }
        }
    }

    public function allBills($id)
    {
        $bills = Bill::select('bills.*','users.name as created_by','customers.name as customer_name')->join('users','users.id','bills.created_by')->join('customers','customers.id','bills.f_customer_no')->where('customers.id',$id)->get();
        if (!$bills) {
            return response()->json([
                'status' => 0,
                'msg' => 'Bills not found !'
            ], 400);
        }
        return response()->json(['status' => 1,'data' => $bills], 200);
    }
}

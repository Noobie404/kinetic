<?php
namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Models\Bill;
use App\Events\SendMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class BillController extends Controller
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

    public function allBills()
    {
        $bills = Bill::select('bills.*','users.name as created_by','customers.name as customer_name')->join('users','users.id','bills.created_by')->join('customers','customers.id','bills.f_customer_no')->get();
        if (!$bills) {
            return response()->json([
                'status' => 0,
                'msg' => 'Bills not found !'
            ], 400);
        }
        return response()->json(['status' => 1,'data' => $bills], 200);
    }

    public function createBill()
    {
        $customers = Customer::select('name','id')->get();
        return response()->json(['status' => 1,'data' => $customers ?? null], 200);
    }

    public function editBill(Request $request,$id)
    {
        $data['bills'] = Bill::select('bills.*','users.name as created_by')->join('users','users.id','bills.created_by')->where('bills.id',$id)->first();
        $data['customers'] = Customer::select('name','id')->get();

        if (!$data['bills']) {
            return response()->json([
                'status' => 0,
                'msg' => 'Bill not found !'
            ], 400);
        }
        return response()->json(['status' => 1,'data' => $data], 200);
    }

    public function updateBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'  => 'required',
            'bill_date' => 'required',
            'name'      => 'required',
            'status'    => 'required',
            'amount'    => 'required',
            'paid'      => 'required',
            'due'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        DB::beginTransaction();
        try {
            $bill =  Bill::find($request->bill_id);
            $bill->bill_name = $request->name;
            $bill->bill_date = date('Y-m-d', strtotime($request->bill_date));
            $bill->amount = $request->amount;
            $bill->status = $request->status;
            $bill->paid = $request->paid;
            $bill->due = $request->due;
            $bill->f_customer_no = $request->customer;
            $bill->created_by = $this->user->id;
            $bill->update();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'status' => 0,
                'msg' => 'Something went wrong !'
            ], 400);
        }
        DB::commit();
        return response()->json([
            'status' => 1,
            'msg' => 'Bill information updated successfully !'
        ], 200);
    }

    public function storeBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'  => 'required',
            'bill_date' => 'required',
            'name'      => 'required',
            'status'    => 'required',
            'amount'    => 'required',
            'paid'      => 'required',
            'due'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        DB::beginTransaction();
        try {
            $bill =  new Bill();
            $bill->bill_name = $request->name;
            $bill->bill_date = date('Y-m-d', strtotime($request->bill_date));
            $bill->amount = $request->amount;
            $bill->status = $request->status;
            $bill->paid = $request->paid;
            $bill->due = $request->due;
            $bill->f_customer_no = $request->customer;
            $bill->created_by = $this->user->id;
            $bill->save();

            event(new SendMail($bill->id));

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'msg' => 'Something went wrong !'
            ], 400);
        }
        DB::commit();
        return response()->json([
            'status' => 1,
            'msg' => 'Bill information successfully !'
        ], 200);
    }

    public function deleteBill(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            Bill::find($id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'msg' => 'Something went wrong !'
            ], 400);
        }
        DB::commit();
        return response()->json([
            'status' => 1,
            'msg' => 'Bill information deleted successfully !'
        ], 200);
    }
}

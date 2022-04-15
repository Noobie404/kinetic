<?php
namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class CustomerController extends Controller
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

    public function allCustomers()
    {
        $customers = Customer::select('customers.*','users.name as created_by')->join('users','users.id','customers.created_by')->get();
        if (!$customers) {
            return response()->json([
                'status' => 0,
                'msg' => 'Customers not found !'
            ], 400);
        }
        return response()->json(['status' => 1,'data'=>$customers], 200);
    }

    public function editCustomer(Request $request,$id)
    {
        $customers = Customer::select('customers.*','users.name as created_by')->join('users','users.id','customers.created_by')->where('customers.id',$id)->first();
        if (!$customers) {
            return response()->json([
                'status' => 0,
                'msg' => 'Customer not found !'
            ], 400);
        }
        return response()->json(['status' => 1,'data'=>$customers], 200);
    }

    public function updateCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|unique:customers,email,{$request->customer_id},id",
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        DB::beginTransaction();
        try {
            $customer   = Customer::find($request->customer_id);
            $customer->name = $request->name;
            $customer->email = $request->email;
            if (isset($request->password)) {
                $customer->password = bcrypt($request->password);
            }
            $customer->update();
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
            'msg' => 'Customer information updated successfully !'
        ], 200);
    }

    public function storeCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|unique:customers,email",
            'name' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        DB::beginTransaction();
        try {
            $customer =  new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->created_by = $this->user->id;
            $customer->password = bcrypt($request->password);
            $customer->save();
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
            'msg' => 'Customer information inserted successfully !'
        ], 200);
    }

    public function deleteCustomer(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            Customer::find($id)->delete();
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
            'msg' => 'Customer information deleted successfully !'
        ], 200);
    }
}

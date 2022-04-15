<?php
namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class CustomerAuthController extends Controller
{
    public function __construct()
    {
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        try {
            $check = Customer::where('email',$request->email)->first();
            if (!$check) {
                return response()->json([
                    'status' => 'error',
                    'errors' => 'Customer not found !'
                ], 400);
            }
            Config::set('auth.providers.users.model', \App\Customer::class);
            Auth::shoulduse('customer');
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
        return $credentials;
            return response()->json([
                    'status' => false,
                    'message' => 'Could not create token.',
                ], 500);
        }
        $format_response = $this->createNewToken($token,$check);
        return response()->json(['status' => 'successs','data'=>$format_response], 200)->header('Authorization', $token);
    }

    public function createNewToken($token,$check){
        $data = [];
        $data['access_token'] = $token;
        $data['token_type'] = 'bearer';
        $data['expires_in'] = date("Y-m-d H:i:s", strtotime("+30 day"));
        $data['user'] = $this->authInfo($check);
        return $data;
    }

    protected function authInfo($user)
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'is_admin'   => $user->is_admin
        ];
    }

    public function logout()
    {
        \Session::flush();
        \Session::regenerate();
        return $this->successResponse(200, 'customer logout!', '', 1);
    }
}

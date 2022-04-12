<?php
namespace App\Http\Controllers\Api;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\SMS;
use App\Traits\MAIL;
use App\Models\Customer;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Mail\Mailer;
// use App\Repositories\Api\Cart\CartInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:customer');
        // if ( isset(Auth::guard('customer')->user()->f_user_id) ) {
        //     $this->middleware( 'guest:customer', [ 'except' => [ 'login' ] ] );
        // } else {
        //     $this->middleware( 'auth:api', [ 'except' => [ 'login' ] ] );
        // }
        $this->middleware( 'auth:api', [ 'except' => [ 'postLogin' ] ] );
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            $check = User::where('email',$request->email)->first();
            if (!$check) {
                return response()->json([
                    'status' => 'error',
                    'errors' => 'User not found !'
                ], 400);
            }
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

 		//Token created, return with success response and jwt token
        // return response()->json([
        //     'status' => true,
        //     'token' => $token,
        // ]);


        // $data = [];
        // $local = $request->header('accept-language');

        // $validator = Validator::make($request->all(), [
        //     'email' => 'required',
        //     'password' => 'required|min:6',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => 'oops! You have entered invalid credentials!'
        //     ], 401);
        // }
        // if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        //     $data = [
        //         'email' => $request->email,
        //         'password' => $request->password
        //     ];
        //     $check = User::where('email',$request->email)->first();
        //     if (!$check) {
        //         return response()->json([
        //             'status' => 'error',
        //             'errors' => 'User not found !'
        //         ], 401);
        //     }
        // }else{
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => 'Invalid email address'
        //     ], 401);
        // }
        // if (! $token = Auth::attempt($data)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => 'oops! You have entered invalid credentials!'
        //     ], 401);
        // }
        // if ($request->type == 'admin') {
        // }else{
        //     // Auth::shouldUse('customer');
        //     if (! $token = Auth::guard('customer')->attempt($data)) {
        //         return response()->json([
        //             'status' => 'error',
        //             'errors' => 'oops! You have entered invalid credentials!'
        //         ], 401);
        //     }
        // }
        // dd(Auth::check());
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
            'email'      => $user->email
        ];
    }

    public function logout()
    {
        \Session::flush();
        \Session::regenerate();
        return $this->successResponse(200, 'customer logout!', '', 1);
    }
}

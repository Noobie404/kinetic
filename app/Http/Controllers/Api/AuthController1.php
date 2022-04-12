<?php
namespace App\Http\Controllers\Api;

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

class AuthController1 extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest:customer');
        // if ( isset(Auth::guard('customer')->user()->f_user_id) ) {
            $this->middleware( 'guest:customer', [ 'except' => [ 'login' ] ] );
        // } else {
        //     $this->middleware( 'auth:api', [ 'except' => [ 'login' ] ] );
        // }
    }
    public function user()
    {
        dd(Auth::user());
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

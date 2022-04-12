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

class CustomerController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function allCustomers(Request $request)
    {
        $customers = Customer::all();
        if (!$customers) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Customers not found !'
            ], 400);
        }
        // dd($customers);
        return response()->json(['status' => 'successs','data'=>$customers], 200);
    }
}

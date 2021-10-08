<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    use ResponseTrait;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        if ($validator->fails()) {
            return $this->returnError($validator->errors()->toJson(), 400);
        }
        $token = JWTAuth::attempt($validator->validated());
        if (! $token) {
            return $this->returnError('فشل تسجيل الدخول', 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:1',
                'confirmed',
            ], //'image' => ['required', 'file', 'mimes:png,jpeg,svg,jpg', 'max:4069'],

        ]);

        if($validator->fails()){
            return $this->returnError($validator->errors()->toJson(), 400);
        }
        try {
            User::create([
                'name'                  => $request['name'],
                'email'                 => $request['email'],
                'password'              => Hash::make($request['password']),
                'image'                 => 'image'
            ]);
            $token = JWTAuth::attempt(['email' => $request['email'], 'password' => $request['password']]);
            return $this->createNewToken($token);
        } catch (\Exception $exception) {

//            return $this->returnError($exception->getMessage(), 500);
            return $this->returnError('حدث خطأ ما, الرجاء المحاولة لاحقا', 500);
        }
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return $this->returnSuccess('تم تسجيل الخروج بنجاح', 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function userProfile(): JsonResponse
    {
        $user = auth()->user();
        $data = [
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'image'         => $user->image,
        ];

        return $this->returnData('this is data of the registered user', $data, 200);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function createNewToken(string $token): JsonResponse
    {
        $expire = auth('api')->factory()->getTTL();
        $expires_in = Carbon::now()->addSeconds($expire);
        return $this->returnData("Here is a valid token",
            [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $expires_in,
            ],
            200);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['signup', 'login']]);
    }

    public function login(Request $request)
    {
        $creds = $request->only([
            'email',
            'password',
        ]);
        $token = Auth::attempt($creds);

        if (! $token) {
            return $this->responseError('auth.invalid_user');
        }

        return $this->respondWithToken($token, 'auth.login_success');
    }

    public function signup(AuthRequest $request)
    {
        $data = $request->only([
            'email',
            'password',
            'name',
        ]);
        $new_user = new User();
        $new_user->name = $data['name'];
        $new_user->email = $data['email'];
        $new_user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $new_user->save();

        $token = Auth::attempt($data);
        return $this->respondWithToken($token, 'auth.success');
    }

    /**
     * Get the authenticated User
     *
     * @return JsonResponse
     */
    public function getCurrentUser()
    {
        try {
            $user = Auth::user();
            $data = [
                'user' => [
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ];
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
        return $this->responseSuccess($data);
    }

    public function logout()
    {
        Auth::logout();
        return $this->responseSuccess([], 'auth.logout');
    }

    protected function respondWithToken($token, $message = null)
    {
        return response()->json([
            'message' => trans($message),
            'token_type' => 'bearer',
            'access_token' => $token,
        ]);
    }
}

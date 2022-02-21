<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'nullable|email|required_without:mobile|exists:users,email',
            'mobile' => 'nullable|required_without:email|exists:users,mobile',
            'password' => 'required|min:6'
        ], [
            'email.required_without' => 'Không được để trống email',
            'email.exists' => 'Email chưa được đăng ký trong hệ thống',
            'mobile.required_without' => 'Không được để trống số điện thoại',
            'password.required' => 'Không được để trống mật khẩu',
            'password.min' => 'Mật khẩu không được dưới 6 ký tự',
            'mobile.exists' => 'Số điện thoại chưa được đăng ký trong hệ thống'
        ]);

        if ($validate->fails()) {
            return $this->response($validate->errors(), 400, $validate->errors()->first());
        }

        $credentials = $request->only(['email', 'password', 'mobile']);

        if ($request->filled('email')) {
            $user = User::where('email', $credentials['email'])->first();

            if (!Hash::check($credentials['password'],$user->password)) {
                return $this->sendError(400, 'Tên đăng nhập hoặc mật không đúng');
            }
        }

        if ($request->filled('mobile')) {
            $user = User::where('mobile', $credentials['mobile'])->first();

            if (!Hash::check($credentials['password'],$user->password)) {
                return $this->sendError(400, 'Tên đăng nhập hoặc mật không đúng');
            }
        }

        return $this->sendResponse(['api_token' => $user->api_token, 'user' => $user], 'Đăng nhập thành công');
    }

    public function getCurrentUser()
    {
        return $this->sendResponse(auth('api')->user(), 'Lấy user thành công');
    }
}

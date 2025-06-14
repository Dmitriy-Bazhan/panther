<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function forgotPassword(){
        $data = [];
        if (auth()->check()) {
            $data = siteData();
        } else {
            $data['data']['settings'] = config('settings');
            $data['data']['languages'] = Lang::all();
        }
        return view('main', $data);
    }

    public function forgotPasswordSendEmail(Request $requset){
        $requset->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $requset->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordToken($token){
        $data = [];
        if (auth()->check()) {
            $data = siteData();
        } else {
            $data['data']['settings'] = config('settings');
            $data['data']['languages'] = Lang::all();
            $data['data']['token'] = $token;
        }
        return view('main', $data);
    }

    public function setNewPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

}

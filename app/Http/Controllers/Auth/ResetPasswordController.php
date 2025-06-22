<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ResetPasswordController extends Controller
{
    /**
     * Handle token in reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkExpiredToken(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        $resetPassword = DB::table('password_reset_tokens')->where('email', '=', $email)->first();

        if (!$resetPassword) {
            throw new ModelNotFoundException();
        }

        if (!Hash::check($token, $resetPassword->token)) {
            throw new BadRequestHttpException('Token Invalid');
        }

        // Check if the token has expired
        $expiration = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
        $datetime = $resetPassword->created_at;
        $isExpired = Carbon::parse($datetime)->addMinutes($expiration)->isPast();
        if ($isExpired) {
            throw new BadRequestHttpException(__('passwords.token_expired'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'token' => $token
        ], 200);
    }

    /**
     * Handle sending the reset password link email.
     *
     * @param \App\Http\Requests\Auth\ResetPasswordRequestt $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(  
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PasswordReset) {
            return response()->json([
                'success' => true,
                'message' => __($status)
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => __($status)
            ], 400);
        }
    }
}

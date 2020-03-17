<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Illuminate\Support\Str;
use Avatar;
use Storage;
class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'confirmation_code' => Str::random(60)
        ]);
        $user->save();
        // avatar
        // $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        // Storage::put('/public/avatars/' . $user->id . '/avatar.png', (string) $avatar);

        if (config('access.users.confirm_email')) {
            // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
            $user->notify(new UserNeedsConfirmation($user->confirmation_code));
        }

        return response()->json([
            'message' => __('exceptions.frontend.auth.confirmation.created_confirm')
        ], 201);

    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param         $user
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        // $credentials['active'] = 1;
        // $credentials['confirmed'] = 1;
        // $credentials['deleted_at'] = null;


        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' =>  __('auth.failed')
            ], 401);
        }

        if (!Auth::User()->isActive()) {
            return response()->json([
                'message' =>  __('exceptions.frontend.auth.deactivated')
            ], 401);
        }

        if(!Auth::User()->isConfirmed()) {
            return response()->json([
                'message' =>  __('exceptions.frontend.auth.confirmation.pending')
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }




}

<?php

namespace App\Http\Controllers\API;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Models\Auth\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Notifications\Frontend\Auth\UserNeedsPasswordReset;

class PasswordResetController extends Controller
{

      use SendsPasswordResetEmails;
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function sendResetLinkEmail(Request $request)
     {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        $response == Password::RESET_LINK_SENT;
        if ($response && $user) {
            return response()->json([
                'message' => __('passwords.sent')
            ]);
           }else{
            return response()->json([
                'message' => __('passwords.user')
            ], 404);
           }
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }


}

<?php

namespace App\Http\Controllers\API;

use App\Models\Auth\User;
use Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Resources\UserPropertyCollection;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

class UserController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {

        return response()->json($request->user());
    }


    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function view(User $user)
    {
    return response()->json($user);
    }


    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function properties(User $user)
    {
        return UserPropertyCollection::collection($user->properties()->paginate(10));
        // return response()->json($user->properties()->paginate(10));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user = $request->user();
        $input = $request->all();
        $email_message = "";
        $validator = Validator::make($input, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        // Start of Upload Files
        if ($request->hasFile('avatar_location')) {
            $avatar_type = "storage";
            if ($user->avatar_location != "") {
                Storage::disk('public')->delete($user->avatar_location);
            }
            $fileNameToUpadte =  'avatars/' .$user->id . '.png';
            $path = $request->file('avatar_location')->move('storage/avatars', $fileNameToUpadte);
            $user->avatar_location = $fileNameToUpadte;
            $user->avatar_type = $avatar_type;
            $user->save();
        }else{
            $avatar_type = "avatar";
            $user->avatar_type = $avatar_type;
            $avatar = Avatar::create($request['first_name'])->getImageObject()->encode('png');
            Storage::put('/public/avatars/' . $user->id . '.png', (string) $avatar);
            $user->save();
        }


        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];


            //Address is not current address so they need to reconfirm
            if ($user->email !== $request['email']) {
                //Emails have to be unique
                if (User::where('email', '=', $request['email'])->count() > 0) {
                    $response = [
                        'success' => true,
                        'message' => __('exceptions.frontend.auth.email_taken')
                    ];
                }else{
                // Force the user to re-verify his email address if config is set
                if (config('access.users.confirm_email')) {
                    $user->confirmation_code = md5(uniqid(mt_rand(), true));
                    $user->confirmed = false;
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                    $user->email = $request['email'];
                   $user->save();
                   $email_message = "Confirmation Mail send for new mail";
                }
            }
                // Send the new confirmation e-mail
            }


        if($request->password){
            $user->password = bcrypt($request->password);
        }

        $user->save();
        $data = $user->toArray();
        $response = [
            'success' => true,
            'data' => $data,
            'email' => $email_message,
            'message' => 'User  updated successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

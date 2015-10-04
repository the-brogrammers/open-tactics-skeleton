<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\UserRepository as Users;

class SessionController extends BaseController {

    public function create(Request $request, Users $users) {
        $email = $request->input('email');
        $password = $request->input('password');

        // Validation here
        $token = $users->authenticate($email, $password);

        if($token) {
            return response()->json([
                'message' => trans('session.created'),
                'access_token' => $token
            ], 201);
        } else {
            return response()->json([
                'message' => trans('session.wrong_credentials')
            ], 403);
        }
    }

}

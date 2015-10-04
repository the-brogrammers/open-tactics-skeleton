<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\UserRepository as Users;

class AccountController extends BaseController {

    public function create(Request $request, Users $users) {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        // Validation here

        if($users->create($name, $email, $password)) {
            return response()->json([
                'message' => trans('account.created')
            ], 201);
        } else {
            return response()->json([
                'message' => trans('account.exists')
            ], 403);
        }
    }

    public function me(Request $request) {
        return $request->user->email;
    }

}

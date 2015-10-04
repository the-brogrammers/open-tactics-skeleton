<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\UserRepository as Users;

class AuthMiddleware {

    protected $auth;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next) {
        $header = $request->headers->get('Authorization');

        if(!$header || strpos($header, 'Bearer') === FALSE) {
            return $this->error();
        }

        $token = substr($header, 7);
        $user = Users::findByToken($token);

        if(!$user) {
            return $this->error();
        }

        $request->user = $user;
        return $next($request);
    }

    private function error() {
        return response()->json([
            'message' => trans('auth.invalid_token')
        ], 403);
    }

}

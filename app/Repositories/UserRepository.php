<?php

namespace App\Repositories;

class UserRepository {

    private $tokenLength = 100;

    public function getByEmailAndPassword($email, $password) {
        return app('db')
            ->table('users')
            ->where('email', $email)
            ->where('password', $password)
            ->first();
    }

    public static function findByToken($token) {
        return app('db')
            ->table('users')
            ->where('access_token', $token)
            ->first();
    }

    public function create($name, $email, $password) {
        $exists = $this->getByEmailAndPassword($email, $password);

        if($exists) {
            return false;
        }

        $now = time();
        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        app('db')
            ->table('users')
            ->insert($user);

        return true;
    }

    public function authenticate($email, $password) {
        $user = $this->getByEmailAndPassword($email, $password);

        if(!$user) {
            return false;
        }

        $now = time();
        $token = $this->getToken($this->tokenLength);
        $data = [
            'access_token' => $token,
            'updated_at' => time()
        ];

        app('db')
            ->table('users')
            ->where('id', $user->id)
            ->update($data);

        return $token;
    }

    private function crypto_rand_secure($min, $max) {
        $range = $max - $min;

        if ($range < 1) {
            return $min;
        }

        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    function getToken($length) {
        $token = '';
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet.= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet.= '0123456789';
        $max = strlen($codeAlphabet) - 1;

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max)];
        }

        return $token;
    }

}

<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class ClientController extends BaseController {

    public function welcome() {
        $config = [
            'turnLength' => config('game.turn_length') * 1000,
            'gameUrl' => url('game'),
        ];

        return view('welcome', [
            'config' => json_encode($config)
        ]);
    }

}

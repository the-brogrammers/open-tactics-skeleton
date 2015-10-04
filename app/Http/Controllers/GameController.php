<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use \Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Response;

class GameController extends BaseController {

    public function index() {
        $data = $this->getRepresentation();

        if(!isAjax()) {
            $response = new StreamedResponse(function() use($data) {
                while(true) {
                    echo streamedData($data);
                    // Send a message on custom channel
                    // echo streamedData($data, 'time');
                    ob_flush();
                    flush();
                    sleep(config('game.turn_length'));
                }
            });

            $response->headers->set('Content-Type', 'text/event-stream');
            return $response;
        } else {
            // Send a message on custom channel
            // $data['event'] = 'time';
            return response()->json($data);
        }
    }

    private function getRepresentation() {
        return [
            'time' => time()
        ];
    }

}

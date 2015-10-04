<?php

function isAjax() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function streamedData($data, $event = false) {
    $stream = "id: " . time() . "\n";

    if($event) {
        $stream .= "event: " . $event . "\n";
    }

    $stream .= "data: " . json_encode($data) . "\n\n";

    return $stream;
}

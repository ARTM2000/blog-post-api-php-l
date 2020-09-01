<?php

function onResponse($action, $data) {

    /* 
        $action = [
            "error" => boolean,
            "status" => number,
            "message" => string
        ];
    */

    return response()->json([
        "data" => $data,
        "info" => $action
    ]);
}
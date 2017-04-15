<?php

    function returnAjaxJson($array,$isurlencode = TRUE) {
        if (!headers_sent())
        {
            header("Content-Type: application/json; charset=utf-8");
        }
        if ($isurlencode == false){
            echo json_encode ( $array );
            ob_end_flush();
            exit;
        }
        foreach ( $array as $key => $value ) {
            if(is_string($value)){
                $array[$key] = urlencode ( $value );
            }
        }
        echo urldecode ( json_encode ( $array ) );
        ob_end_flush();
        exit;
    }

    function returnAjaxJsonFastcgi($array,$isurlencode = TRUE) {
        if (!headers_sent())
        {
            header("Content-Type: application/json; charset=utf-8");
        }
        if ($isurlencode == false){
            echo json_encode ( $array );
            ob_end_flush();
            exit;
        }
        foreach ( $array as $key => $value ) {
            if(is_string($value)){
                $array[$key] = urlencode ( $value );
            }
        }
        echo urldecode ( json_encode ( $array ) );
        ob_end_flush();
        fastcgi_finish_request();
    }

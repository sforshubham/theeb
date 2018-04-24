<?php

function pr($param){
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

function object_to_array($obj, $escape_keys = []) {
    if (is_object($obj)) {
    	$obj = (array) $obj;
    }
    if (is_array($obj)) {
        foreach ($obj as $key => $val) {
            if (array_key_exists($key, $escape_keys)) {
                unset($obj[$key]);
            } else {
                $obj[$key] = object_to_array($val, $escape_keys);
            }
        }
    }
    return $obj; 
}


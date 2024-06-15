<?php
if(!function_exists('json')){
    function json($data){
        if($data){
            print(json_encode($data));
        }
    }
}
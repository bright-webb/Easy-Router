<?php
namespace EasyAPI\Controller;

class ApiController {
    public function index(){
        
        return json(['message' => 'You are here']);
    }

}
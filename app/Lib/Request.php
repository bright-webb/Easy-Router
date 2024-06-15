<?php
namespace EasyAPI\Lib;

class Request{
    private $input;
    private $path;
    private $method;
    private $query;
    private $bodyParams;
    private $formData;
    private $cookies;
    private $headers;
    private $file;

    public function __construct(){
        $this->input = $_POST;
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->query = $_GET;
        $this->formData = array_merge($_GET, $_POST);
        $this->cookies = $_COOKIE;
        $this->file = $_FILES;
    }

    public function input($key = null, $default = null){
        if($key === null){
            return $this->input;
        }
         return filter_input(INPUT_POST, $this->input[$key], FILTER_SANITIZE_SPECIAL_CHARS) ?? $default;
    }

    public function query($key = null, $default = null){
        if($key === null){
            return $this->query;
        }
        return $this->query[$key] ?? $default;
    }

    public function file($key = null){
        if($key === null){
            return $this->file;
        }
        return $this->file[$key] ?? null;
    }
}
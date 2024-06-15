<?php
namespace EasyAPI\Lib;

class Router {
    private $routes = [];
    public function add($method, $path, $handler){
        $this->routes[] = [
            'method' => $method,
            'path' => trim($path, '/'),
            'handler' => $handler
        ];
    }

    public function run($requestMethod, $requestUri){
        $requestMethod = strtoupper($requestMethod);

        // Check if method is supported
        if (!$this->isMethodSupported($requestMethod)) {
            http_response_code(405); // Method not allowed
            echo "405 Method Not Allowed";
            return;
        }
        $requestUri = trim($requestUri, '/');
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                $handler = $route['handler'];
                if (is_callable($handler)) {
                    return call_user_func($handler);
                }
                elseif(is_array($handler) && count($handler) == 2){
                    $controllerName = $handler[0];
                    $methodName = $handler[1];

                    // Check if controller class and method exists
                    if(class_exists($controllerName) && method_exists($controllerName, $methodName)){
                        $instance = new $controllerName();
                        return call_user_func([$instance, $methodName]);
                    }
                    else{
                        // Handle controller not exists error
                        http_response_code(500);
                        echo "Internal Server Error: $methodName method for $controllerName not found";
                        return;
                    }
                }
                else{
                    // Handle invalid handler error
                    http_response_code(500);
                    echo "Internal Server Error: Invalid handler for $requestMethod $requestUri";
                    return;
                }
                
            }
        }
        http_response_code(404);
        echo "404 Not found";
    }

    private function isMethodSupported($method) {
        // Supported methods
        $supportedMethods = ['GET', 'POST', 'PUT', 'DELETE'];

        // Check if method is in array
        return in_array($method, $supportedMethods);
    }

}
<?php
namespace Redia\Framework;
use Redia\Framework\Routing\Router;
use Redia\Framework\Routing\Route;
/**
 * Class App
 * @package Redia\Framework
 */
class App
{
    /*
     *  @var array    Config cache
     */
    protected $config;

    public function __construct(array $config){

        $this->config = $config;
    }

    /*
     *  Run the application
     */
    public function run(){

        $router = new Router($this->config['routes']);
        $route = $router->findRoute();

        if($route instanceof Route){

            $controllerReflection = new \ReflectionClass('App\Controllers\\'.$route->controller);

            if($controllerReflection->hasMethod($route->action)){
                $controller = $controllerReflection->newInstance();
                $methodReflection = $controllerReflection->getMethod($route->action);
                $methodReflection->invokeArgs($controller, $route->params);
            } else {
                echo 'doest has this action';
            }
        }
        else {
            //@TODO: Return 404 Response
        }

    }

}
<?php
namespace Redia\Framework;
use Redia\Framework\Routing\Router;
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

        //$router = new Router();

    }

}
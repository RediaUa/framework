<?php
namespace Redia\Framework\Routing;


class Router
{
    /*
     * @var  Route map cache;
     */
    protected  $map;

    /*
     *  Router constructor
     * @param mapping   Route mapping
     */
    public function __construct($mapping){

        $this->map = $mapping;

        $this->currentUri = $_SERVER['REQUEST_URI'];
        $this->currentMethod = $_SERVER['REQUEST_METHOD'];

    }
}
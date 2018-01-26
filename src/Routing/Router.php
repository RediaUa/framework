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
    public function __construct(array $mapping){

        $this->map = $mapping;

        $this->currentUri = $_SERVER['REQUEST_URI'];
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

    }

    /*
     *  Find matching route using routing map
     */
    public function findRoute(){
        $result = null;

        if(!empty($this->map)){
            foreach ($this->map as $name => $routeData){
                $path = $routeData['path'];
                $pattern = $this->transformToRegExp($path);
                    if(preg_match($pattern, $this->currentUri, $matches)){
                        if(!empty($routeData['method']) &&  strtoupper($this->requestMethod) != strtoupper($routeData['method'])){
                            continue;
                        }

                        $result = $routeData;
                        $result['params'] = $this->parseParams($path);
                        $result = new Route($result);

                        break;
                    }
            }
        }

        return $result;

    }

    /*
     *  Transform uri path to regexp
     */
    private function transformToRegExp(string $path): string {
        //make common case regexp
        $regexp = '/^'.str_replace('/', '\/', $path).'[\/]*$/';

        //replace params with regexp
        $regexp = preg_replace('\/{[/w/d_]+\}/i','([\w\d_]+)', $regexp);

        return $regexp;
    }

    /*
     *  parse uri params
 *      @path string Route matching path (mask)
     *
     *  @return array
     */
    private function parseParams(string $path){
        $params = [];

        //Searching for params in the route pattern:
        if(preg_match_all('/\{([\w\d_]+)\}/i', $path, $matches)){
            //get params names
            $paramNames = $matches[1];
            //get param values
            preg_match($this->transformToRegexp($path), $this->currentUri, $paramMatches);
            array_shift($paramMatches); // Get rid of 0th element
            $paramValues = $paramMatches;

            // Make assoc array of parsed params:
            $params = array_combine($paramNames, $paramValues);
        }

        return $params;

    }

}
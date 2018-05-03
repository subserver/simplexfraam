<?php namespace SimplexFraam;


use \Symfony\Component\HttpFoundation\Request;

class Route
{
    private $target = null;

    /**
     * @var int $middleWareIndex
     */
    private $middleWareIndex = 0;

    /**
     * @var Middleware[] $middleWare
     */
    private $middleWare = [];
    /**
     * @var mixed[] $payloads
     */
    private $payloads = [];
    /**
     * @var int[] $beforeMW
     */
    private $beforeMW = [];
    /**
     * @var int[] $afterMW
     */
    private $afterMW = [];
    /**
     * @var int[] $enforceMW
     */
    private $enforceMW = [];

    public function __construct($method, $route, $target, $name = null)
    {
        $this->target = $target;
        return $this;
    }

    public function run(Request &$req, Response &$res){
        foreach($this->beforeMW as $mwKey){
            $result = $this->executeMiddleware($mwKey, [&$req, &$res]);
            if($result instanceof Error){
                $res->error($result);
            }
        }

        foreach($this->enforceMW as $mwKey){
            $result = $this->executeMiddleware($mwKey, [&$req, &$res]);
            if($result instanceof Error){
                $res->error($result)->send();
                exit();
            } elseif ($result !== true){
                $res->error(new Error(500, "Enforced middleware `" . $this->middleWare[$mwKey] . "` not true."))->send();
            }
        }

        /**
         * Execute the target.
         */
        if(is_string($this->target)){
            $parts = explode("::", $this->target);
            $parts[0] = SimplexFraam::$userNamespace . $parts[0];
            $result = call_user_func_array($parts, [&$req, &$res]);
            if(!empty($result)){
                $res->assign("result", $result);
            }
        } elseif(is_callable( $this->target )) {
            //Execute controller.
            $result = call_user_func_array( $this->target, [&$res, &$req]);
            if(!empty($result)){
                $res->assign("result", $result);
            }
        }

        foreach($this->afterMW as $mwKey){
            $result = $this->executeMiddleware($mwKey, [&$req, &$res]);
            if($result instanceof Error){
                $res->error($result);
            }
        }

        return $res;
    }

    /**
     * Attach a middleware that must return true to continue.
     *
     * @param Middleware[]|Middleware   $middleware
     * @param array                     $payload
     *
     * @return $this
     */
    public function enforce($middleware, $payload = []){
        $this->queueMiddleware($middleware, $payload,$this->enforceMW);
        return $this;
    }

    /**
     * Attach a middleware that must not return an Error to continue.
     * Will be run before the route.
     *
     * @param Middleware[]|Middleware   $middleware
     * @param array                     $payload
     *
     * @return $this
     */
    public function before($middleware, $payload = []){
        $this->queueMiddleware($middleware, $payload,$this->beforeMW);
        return $this;
    }

    /**
     * Attach a middleware that will be run after.
     * The results do not effect success or failure..
     *
     * @param Middleware[]|Middleware   $middleware
     * @param array                     $payload
     *
     * @return $this
     */
    public function after($middleware, $payload = []){
        $this->queueMiddleware($middleware, $payload,$this->afterMW);
        return $this;
    }

    private function storeMiddleware($middleWare, $payload){
        $this->middleWare[$this->middleWareIndex] = $middleWare;
        $this->payloads[$this->middleWareIndex] = $payload;
        return $this->middleWareIndex++;
    }

    /**
     * @param MiddleWare|Middleware[]   $middleware
     * @param mixed                     $payload
     * @param array                     $queue
     *
     * @return $this
     */
    private function queueMiddleware($middleware, $payload, &$queue){
        if(!is_array($middleware)){
            $middleware = [$middleware];
        }
        foreach($middleware as $mw){
            $key = $this->storeMiddleware($mw, $payload);
            $queue[] = $key;
        }
        return $this;
    }

    private function executeMiddleware($mwKey, $parameters){
        if(isset($this->payloads[$mwKey])){
            $parameters[] = $this->payloads[$mwKey];
        }
        $parts = [$this->middleWare[$mwKey], "run"];
        $parts[0] = SimplexFraam::$userNamespace . $parts[0];
        return call_user_func_array($parts, $parameters);
    }

}
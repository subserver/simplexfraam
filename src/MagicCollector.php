<?php namespace SimplexFraam;

trait MagicCollector
{
    /**
     * Automagically collect required parts.
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        $methodName = "get" . ucfirst($name);
        if(method_exists($this, $methodName)){
            return call_user_func([$this, $methodName]);
        }
    }
}
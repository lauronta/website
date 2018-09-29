<?php

namespace Framework\Router ;

/**
 * Class Route
 * Represent a match route
 */
class Route
{

    private $name;
    private $callback;
    private $parameters;

    public function __construct(string $name, callable $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback():callable
    {
        return $this->callback;
    }

    /***
     * Retrieve the url parameters
     * @return string[]
     */
    public function getParams():array
    {
        return $this->parameters;
    }
}

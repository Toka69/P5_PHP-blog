<?php

namespace Lib\Router;

/**
 * Route
 */
class Route
{
    private string $name;
    private string $path;
    private string $controller;
    private string $action;
    
    /**
     * __construct
     *
     * @param  mixed $name
     * @param  mixed $path
     * @param  mixed $controller
     * @param  mixed $action
     * @return void
     */
    public function __construct(string $name, string $path, string $controller, string $action)
    {
        $this->name = $name;
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }
   
    /**
     * getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * setName
     *
     * @param  mixed $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * getPath
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * setPath
     *
     * @param  mixed $path
     * @return void
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }
    
    /**
     * getController
     *
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }
    
    /**
     * setController
     *
     * @param  mixed $controller
     * @return void
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }
    
    /**
     * getAction
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
    
    /**
     * setAction
     *
     * @param  mixed $action
     * @return void
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }
}

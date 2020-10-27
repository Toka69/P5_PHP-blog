<?php

namespace Lib\Router;

/**
 * Class Route
 * @package Lib\Router
 */
class Route
{
    private string $name;
    private string $path;
    private string $controller;
    private string $action;

    /**
     * Route constructor.
     * @param string $name
     * @param string $path
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $name, string $path, string $controller, string $action)
    {
        $this->name = $name;
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }
}

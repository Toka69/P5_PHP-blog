<?php 
namespace Lib\Router;

class Route
{
    private string $_name;
    private string $_path;
    private string $_controller;
    private string $_action;

    public function __construct(string $name, string $path, string $controller, string $action)
    {
        $this->_name = $name;
        $this->_path = $path;
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->_path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->_path = $path;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->_controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->_controller = $controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->_action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->_action = $action;
    }
}
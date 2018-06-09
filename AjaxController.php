<?php
require_once "init.php";
if (session_status() == PHP_SESSION_NONE) session_start();

/**
 * Crida la funció del controlador segons les variables POST obtingudes
 */

if (isset($_POST['function']) && isset($_POST['caller'])) {
	$controller = $_POST['caller'] . "Controller";
	$mc = new AjaxController($controller);
	$mc->loadFunction($_POST['function'], $_POST);
}

class AjaxController
{
    const NAMESPACE = "Campusapp\\Presentation\\Controller\\";
    private $controller;
	private $defaultController;
	
	function __construct($controllerName) {
	    $controllerName = self::NAMESPACE . $controllerName;
	    if (class_exists($controllerName)) {
	        $this->controller = new $controllerName();
	    } else {
	        $this->controller = null;
	    }
	    $defaultControllerName = self::NAMESPACE . "Controller";
	    $this->defaultController = new $defaultControllerName();
	}

	// loads a function from a class
	public function loadFunction($fName, $vars)
	{
	    try {
	        if ($this->controller != null && method_exists($this->controller, $fName)) {
	            echo json_encode([TRUE, $this->controller->{$fName}($vars)]);
	        } else if (method_exists($this->defaultController, $fName)) {
	            echo json_encode([TRUE, $this->defaultController->{$fName}($vars)]);
	        } else {
	            throw new \Exception();
	        }
	    } catch (\Exception $e) {
	        echo json_encode([FALSE, $e->getMessage()]);
	    }
	}
}

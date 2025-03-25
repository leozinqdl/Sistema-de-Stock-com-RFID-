<?php
class ControllerFront {

    private static $instance;
	public $baseUrl = null;
	public $controllerDir = null;
	public $defaultController = null;
	public $defaultMethod = null;
	public $fileExtension = ".php";

	public function __construct(){
		if (isset(self::$instance)) {
			throw new Exception("This class just has been instanced!");
		}
		return "ControllerFront foi instanciado!";
	}

	/**
	 * Creates a singleton instance of ControllerFront
	 *
	 * @return ControllerFront
	 */
	public static function getInstance(){
		if (! isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get a string as value which contents the base URL
	 *
	 * @return string
	 */
	public function getBaseUrl(){
		return $this->baseUrl;
	}

	/**
	 * Set a string as value to the base URL
	 *
	 * @param string $url
	 */
	public function setBaseUrl($url){
		$this->baseUrl = $url;
	}

	/**
	 * Get a string as a Controller Directory
	 *
	 * @return string
	 */
	public function getControllerDir(){
		return $this->controllerDir;
	}

	/**
	 * Set a valid directory to Controller
	 *
	 * @param string $dir
	 */
	public function setControllerDir($dir){
		if (! file_exists($dir)) {
			throw new Exception("Diretorio do controlador nao existente!");
		} elseif (! is_dir($dir)) {
			throw new Exception("Diretorio do controlador nao e valido!");
		} elseif (! is_readable($dir)) {
			throw new Exception("Diretorio do controlador ilegivel!");
		}
		$this->controllerDir = $dir;
	}
	/**
	 * @return string
	 */
	public function getDefaultController(){
		return $this->defaultController;
	}

	/**
	 * @param string $defaultController
	 */
	public function setDefaultController($defaultController){
		$this->defaultController = $defaultController;
	}
	
	/**
	 * @return 'desconhecido'
	 */
	public function getDefaultMethod(){
		return $this->defaultMethod;
	}

	/**
	 * @param 'desconhecido' $defaultMethod
	 */
	public function setDefaultMethod($defaultMethod){
		$this->defaultMethod = $defaultMethod;
	}

	protected static function getParameters($uri){
		for ($i = 2; $i < count($uri); $i ++)
			$parameters[] = $uri[$i];
		return $parameters;
	}

	protected function getController($string){
		if ($string != NULL) {
			$string = strtolower($string);
			$controller = ucfirst($string) . "Controller";
		} elseif ($this->getDefaultController() != null) {
			$default = strtolower($this->getDefaultController());
			$controller = ucfirst($default) . "Controller";
		} elseif (($is_admin == "admin") && ($string == null)) {
			$controller = "AdminController";
		} else {
			$controller = "IndexController";
		}
		return $controller;
	}

	protected function checkFileController($controller_path){
		$full_path = $controller_path . $this->fileExtension;
		if (! file_exists($full_path)) {
			throw new Exception("Called Controller " . $full_path . " does not exists!");
		}
		return $full_path;
	}

	protected function getMethod($string){
		if ($string != NULL) {
			$method = strtolower($string) . "Action";
		} elseif ($this->getDefaultMethod() != NULL) {
			$method = strtolower($this->getDefaultMethod()) . "Action";
		} else {
			$method = "indexAction";
		}
		return $method;
	}

	public function run(){

		//Treating URI string
		$uri = $_SERVER['REQUEST_URI'];
		$base_uri_length = strlen($this->getBaseUrl());
		$rest_uri = substr($uri, $base_uri_length + 1);
		if (substr_count($rest_uri, "?") > 0) {
			$rest_uri = substr($rest_uri, 0, strpos($rest_uri, "?"));
		}
		$array_rest_uri = explode("/", $rest_uri);
		
		//Treating Controller File
		$req_controller = $this->getController($array_rest_uri[0]);
		$url_controller = $this->controllerDir . "/";
		$check_file = $this->checkFileController($url_controller . $req_controller);
			
		require_once $check_file;

		//Treating controller class
		$controller_class = $req_controller;
		if (! class_exists($controller_class)) {
			throw new Exception("Classe controladora..: " . $controller_class . " nao existe nesse controlador.");
		}
			
		$controller = new $controller_class();
			
		if (! $controller instanceof ControllerView) {
			throw new Exception("Esse controlador não extende a classe ControllerView.");
		}
		
		//Treating Controller Action
		$req_action = $this->getMethod($array_rest_uri[1]);
			
		if (! method_exists($controller, $req_action)) {
			throw new Exception("Action " . $req_action . " nao existente.");
		}
		if (! is_callable(array($controller, $req_action))) {
			throw new Exception("Chamada de metodo inexistente!");
		}
		
		//Treating parameters
		$req_parameters = self::getParameters($array_rest_uri);
			
		$controller->$req_action($req_parameters);
	}
}

<?php
class ControllerView
{
	/**
	 * Base Directory for view files
	 *
	 * @var string
	 */
	public $baseDir = VIEW_BASE_PUBLIC_PATH;
	public $indexDir = VIEW_BASE_INDEX_PATH;
	public $indexFile = VIEW_INDEX;
	public $viewSuffix = VIEW_INDEX_EXTENSION;
	
	/**
	 * Class construct
	 *
	 */
	public function __construct()
	{
		$this->checkBaseDir($this->baseDir);
		$this->checkIndexDir($this->indexDir);
	}
	
	/**
	 * Check if default views directory exists.
	 *
	 * @param string $baseDir
	 * @return true;
	 */
	public function checkBaseDir($baseDir)
	{
		if (! is_dir($baseDir))
		{
			throw new Exception("Views directory '" . $baseDir . "' does not exists.");
		}
		return true;
	}
	
	public function checkBaseDirAdmin($baseDirAdmin)
	{
		if (! is_dir($baseDirAdmin))
		{
			throw new Exception("Views directory '" . $baseDirAdmin . "' does not exists.");
		}
		return true;
	}
	
	/**
	 * Check if index file exists
	 * If that exists, then return true;
	 *
	 * @param string $indexDir
	 * @return true;
	 */
	public function checkIndexDir($indexDir)
	{
		if (! is_dir($indexDir))
		{
			throw new Exception("Default 'Index' directory not found!");
		} elseif (! file_exists($indexDir . "/" . $this->indexFile . $this->viewSuffix)) {
			throw new Exception("Default index page not found!");
		}
		return true;
	}
	
	/**
	 * Check if the request file exists
	 * If request file exists, then return the path.
	 *
	 * @param string $path
	 * @return $path
	 */
	public function checkRequestFile($path)
	{
		if (! file_exists($path))
		{
			throw new Exception("The file '" . $path . "' does not exists.");
		}
		return $path;
	}
	
	public function checkControllerViewFile($controller)
	{
		if (! file_exists(CONTROLLER_ADMIN_PATH . $controller . $this->viewSuffix))
		{
			throw new Exception("The file '" . $controller . $this->viewSuffix . "' does not exists.");
		}
		return $controller;
	}
	
	/**
	 * Função principal que imprime a saida do front end.
	 * Com cabeçalho - conteudo - rodape
	 */
	public function run($controller = null, $action = null, $vetdatabase = null)
	{
		if(isset($_SESSION["id_user_session"]))
		{
			$header_value = "index/header";
			$footer_value = "index/footer";
		}
		else
		{
			$header_value = "login/header";
			$footer_value = "login/footer";
		}
		$controller_front = ControllerFront::getInstance();
		$header_file = $this->baseDir.$header_value.$this->viewSuffix;
		$header_file = $this->checkRequestFile($header_file);
		require_once ($header_file);
					
		$this->render($controller, $action, $vetdatabase);
					
		$footer_file = $this->baseDir.$footer_value.$this->viewSuffix;
		$footer_file = $this->checkRequestFile($footer_file);
		require_once ($footer_file);
	}
	
	/**
	 * Função em ajax que imprime a saida do front end.
	 * Com cabeçalho - conteudo - rodape
	 */
	public function runAjax($controller = null, $action = null, $vetdatabase = null)
	{
		$controller_front = ControllerFront::getInstance();
		$header_file = $this->baseDir."index/headerajax".$this->viewSuffix;
		$header_file = $this->checkRequestFile($header_file);
		require_once ($header_file);
		
		$this->render($controller, $action, $vetdatabase);
		
		$footer_file = $this->baseDir."index/footerajax".$this->viewSuffix;
		$footer_file = $this->checkRequestFile($footer_file);
		require_once ($footer_file);
	}
	
	/**
	 * Função que imprime somente o conteudo na tela.
	 */
	public function runPrint($controller = null, $action = null, $vetdatabase = null)
	{
	    $this->render($controller, $action, $vetdatabase);
	}
	
	public function render($controller, $action, $vetdatabase)
	{
	    $id_user_session = $_SESSION["id_user_session"];
	    $controller_req = $this->baseDir . $controller . "/" . $action . $this->viewSuffix;
	    $controller_req = $this->checkRequestFile($controller_req);
	    require_once ($controller_req);
	}
}
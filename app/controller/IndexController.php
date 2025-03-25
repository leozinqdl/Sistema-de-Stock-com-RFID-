<?php
class IndexController extends ControllerView
{
	public function mainAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("index","main");
	}
	public function indexAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("index","main");
	}

	public function errorAction()
	{
	    $perm = new Permission();
	    $perm->isSessionActive();
	    $vetdatabase["msg_fail"] = $_REQUEST["msg_fail"];
	    $this->run("index","error",$vetdatabase);
	}
	
	public function notpermissionAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("index","notpermission");
	}
	
	public function notfoundAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("index","notfound");
	}
	
	public function constructionAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("index","construction");
	}
}
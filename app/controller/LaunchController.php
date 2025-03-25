<?php
class LaunchController extends ControllerView
{
	public function insertAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("launch","insert");
	}
}
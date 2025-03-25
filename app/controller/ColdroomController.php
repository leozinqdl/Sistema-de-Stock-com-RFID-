<?php
class ColdroomController extends ControllerView
{
	public function insertAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("coldroom","insert");
	}
}
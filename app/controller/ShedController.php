<?php
class ShedController extends ControllerView
{
	public function insertAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("shed","insert");
	}
}
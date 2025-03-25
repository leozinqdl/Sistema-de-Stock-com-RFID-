<?php
class OnionController extends ControllerView
{
	public function insertAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("onion","insert");
	}
}
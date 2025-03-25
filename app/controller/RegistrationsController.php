<?php
class RegistrationsController extends ControllerView
{
	public function insertAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$this->run("registrations","insert");
	}
}
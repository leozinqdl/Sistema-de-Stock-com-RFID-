<?php
class WhichpalletController extends ControllerView
{
    public function insertAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("whichpallet", "insert");
    }   
    public function registerAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->runPrint("whichpallet", "register");
    }   
    public function insertrfidAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("whichpallet", "insertrfid");
    }
}
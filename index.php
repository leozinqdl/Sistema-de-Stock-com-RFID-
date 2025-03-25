<?php
require_once("config.php");
$controller = ControllerFront::getInstance();
$controller->setBaseUrl("/stock");
$controller->setControllerDir("app/controller");
$controller->run();
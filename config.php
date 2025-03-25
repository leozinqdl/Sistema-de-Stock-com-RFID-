<?php
set_include_path(get_include_path() . PATH_SEPARATOR . ".");
set_include_path(get_include_path() . PATH_SEPARATOR . "app/controller");
set_include_path(get_include_path() . PATH_SEPARATOR . "app/view");
set_include_path(get_include_path() . PATH_SEPARATOR . "app/model");
set_include_path(get_include_path() . PATH_SEPARATOR . "libs");
set_include_path(get_include_path() . PATH_SEPARATOR . "public");

function my_autoload ($pClassName) {
    require_once($pClassName . ".php");
}
spl_autoload_register("my_autoload");

/*VIEW*/
define("VIEW_BASE_PUBLIC_PATH", "app/view/");
define("VIEW_BASE_ADMIN_PATH", "app/view");
define("VIEW_BASE_INDEX_PATH", "app/view");
define("VIEW_INDEX", "index/main");
define("VIEW_INDEX_EXTENSION", ".php");

/*CONTROLLER*/
define("CONTROLLER_EXTENSION", ".php");
define("DOCUMENT_ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"]);
//define("IP_SERVER", "https://gestao.fazendamandaguari.com.br");
define("URL_BASE", "/stock");

/*----------------TELEGRAM----------------*/
define("loginmandaguari_bot", "5091085016:AAHfIu0EXgNS13pACLQJDo76JzI9l1yewoI");    //login e diversas mensagens de compras dentre outras
/*----------------TELEGRAM----------------*/
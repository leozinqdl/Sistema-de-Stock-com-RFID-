<?php	
require_once "DbConnection.php";
class Permission
{
	/*-------------------- PRIVATE --------------------------*/
    public function isSessionActive()
    {
        session_start();
        if(!isset($_SESSION["id_user_session"]))
        {
            session_destroy();
            header("location: ".URL_BASE."/login/in");
        }
        else
            return $_SESSION["id_user_session"];
    }
	/*-------------------- END PRIVATE --------------------------*/
}
<?php
class loginModel
{
    public function loginSelect($login_user, $pass_user)
    {
        $form = new FormValidate();
        $dbcon = new DbConnection();
        $login_user_db = $form->string_db($login_user);
        $pass_user_db = $form->string_db($form->str_encryption($pass_user));
        $dbcon->Query("select 	id_user
					   from		tb_user
					   where	login_user = $login_user_db and
                                pass_user = $pass_user_db and status_user = true");
        if($Field = $dbcon->Fetch())
        {
            session_start();
            $_SESSION["id_user_session"] = $Field["id_user"];
            return true;
        }
        return false;
    }
    
    public function passwordSelect($id,$password)
    {
        $dbcon = new DbConnection();
        $dbcon->Query("SELECT login_user FROM tb_user WHERE id_user = $id and pass_user = $password");
        
        if(!$dbcon->Rows())
            return true;
        return false;
    }
    
    public function passwordUpdate($id, $password)
    {
        $dbcon = new DbConnection();
        $dbcon->Query("UPDATE tb_user SET pass_user = $password WHERE id_user = $id");
    }
}
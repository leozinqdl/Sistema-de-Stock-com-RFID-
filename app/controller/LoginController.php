<?php
class LoginController extends ControllerView
{
    public function inAction()
    {
        if(isset($_SESSION["id_user_session"]))
            header("location: ".URL_BASE."/index");

        if(empty($_REQUEST["JPOST"]))
            $this->run("login","in");
        else
        {
            $model = new loginModel();
            $user_name = $_REQUEST['user_name'];
            $user_pass = $_REQUEST['user_pass'];
            if(!$model->loginSelect($user_name, $user_pass))
            {
                $AlertJquery = new AlertJquery();
                $AlertJquery->printScn("red", "pan_tool", "Usuario nao localizado!");
            }
            else
            {
                if($_SESSION["page_redirect"])
                {
                    ?><script>top.parent.location="<?=$_SESSION["page_redirect"]?>";</script><?
				}
				else
				{
				    ?><script>top.parent.location="<?=URL_BASE?>/index";</script><?
				}
			}
		}
	}

	public function passwordAction()
	{
		$perm = new Permission();
		$id_user_session = $perm->isSessionActive();
		$model = new loginModel();

		if(empty($_REQUEST["JPOST"]))
			$this->run("login","password");
		else
		{
			$form = new FormValidate();
			$AlertJquery = new AlertJquery();
			$userModel = new userModel();

			$password_db = $form->string_db($_REQUEST["password"]);
			$new_password_db = $form->string_db($_REQUEST["new_password"]);
			$new_password_confirm_db = $form->string_db($_REQUEST["new_password_confirm"]);
			$password_cript_db = $form->string_db($form->str_encryption($_REQUEST["password"]));
			$new_password_cript_db = $form->string_db($form->str_encryption($_REQUEST["new_password"]));

			if($userModel->isPasswordSelect($id_user_session, $password_cript_db))
				$AlertJquery->addAlert("O campo 'Senha Atual' não confere e não pode ser vazio!");
			if($new_password_db == "NULL" || $_REQUEST["new_password_confirm"] != $_REQUEST["new_password"])
				$AlertJquery->addAlert("Os campos 'Nova Senha' e 'Confirmar Senha' não podem ser vazios e devem ser iguais!");
			else
			if(!$form->str_password($_REQUEST["new_password"]))
				$AlertJquery->addAlert("Senha Inválida! Digite números ou caracteres válidos de no mínimo 6 dígitos!");	
				
			if($AlertJquery->hasAlert())
				$AlertJquery->printAlert(2);
			else
			{
			    $userModel->setPassUser($id_user_session, $new_password_cript_db);
				$AlertJquery->addAlert("Senha alterada com sucesso!");
				$AlertJquery->printAlert(1, "/index");
			}
		}
	}
	
	public function logoffAction()
	{
		$perm = new Permission();
		$perm->isSessionActive();
		$AlertJquery = new AlertJquery();
		
		if(empty($_REQUEST["JPOST	"]))
		{
			$AlertJquery->addAlert("Deseja realmente sair do sistema?");
			$AlertJquery->printAlert(4,null,"/login/logoff/?AJAX=1");
		}
		else
		{
			session_destroy();
			?><script>top.parent.location="<?=URL_BASE?>/index";</script><?
		}
	}
}
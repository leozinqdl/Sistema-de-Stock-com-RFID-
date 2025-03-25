<?php
class userModel
{
    public function userSelect($all_users = null)
    {
        $dbcon = new DbConnection();
        if($all_users)
            $sql = " and status_user = true";
        $dbcon->Query("select   id_user,
                                name_user
					   from 	tb_user
					   where	1=1
							    $sql
                                order by name_user");
	    While($field = $dbcon->Fetch())
	    {
	        $id_user = $field["id_user"];
	        $name_user = $field["name_user"];
	        $returnArray[$id_user] = $name_user;
	    }
	    return $returnArray;
	}
    
    public function visualizeSelect($id_user)
    {
        $form = new FormValidate();
        $dbcon = new DbConnection();
        $dbcon->Query("select	name_user,
                                login_user,
                                status_user
					   from	    tb_user
					  where  	id_user = $id_user");
        
        if($field = $dbcon->Fetch())
        {
            $return["id_user"] = $id_user;
            $return["name_user"] = $field["name_user"];
            $return["login_user"] = $field["login_user"];
            $return["status_user"] = $field["status_user"];
            $return["status_user_print"] = $form->db_boolean(1,$field["status_user"]);
            return $return;
        }
        return false;
    }

    
    /*-------------------- GET´S --------------------------*/
    public function isPasswordSelect($id_user, $pass_user)
    {
        $dbcon = new DbConnection();
        $dbcon->Query("select login_user from tb_user where id_user = $id_user and pass_user = $pass_user");
        if(!$dbcon->Rows())
            return true;
        return false;
    }
    
    public function getNameUser($id_user)
    {
        $dbcon = new DbConnection();
        $dbcon->Query("select name_user from tb_user where id_user = $id_user");
        if($Campo = $dbcon->Fetch())
            return $Campo["name_user"];
        return null;
    }
    
    
    /*-------------------- SET´S --------------------------*/
    public function setPassUser($id_user, $pass_user)
    {
        $dbcon = new DbConnection();
        $dbcon->Query("update tb_user set pass_user = $pass_user where id_user = $id_user");
    }
    

	/*-------------------- header opções --------------------------*/  
	public function userCenterPrint($id_user)
	{
	    $vet_user = $this->visualizeSelect($id_user);
	    ?><div class="textfield_center">
        	<div><?=$vet_user["name_user"]?></div>
        </div><?
	}
}
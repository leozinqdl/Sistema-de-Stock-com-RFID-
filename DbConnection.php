<?php
class DbConnection
{
	public $Resource;
	public $Connection;
	public $Database = "db_forms";
	public $Host = "localhost";
	public $User = "root";
	public $Password = "";

	function __construct()
	{
	    //'p:'. = para forçar a conexao a ficar ativa assim como no mysql_conexao da versao 5.3
	    $this->Connection = mysqli_connect('p:'.$this->Host, $this->User, $this->Password, $this->Database);
		if(!$this->Connection)
		    $this->PrintError(mysqli_connect_error($this->Connection));
	}

	function Query($Comando)
	{
	    $this->Resource = mysqli_query($this->Connection, $Comando);
	    
		if(!$this->Resource)
		{
			$erro = mysqli_error($this->Connection);
			$this->PrintError($Comando."  -> ".$erro);
		}
		$this->ProcessKill(300);
	}

	function Fetch()
	{
		return mysqli_fetch_array($this->Resource);
	}
	
	function Rows()
	{
		return mysqli_num_rows($this->Resource);
	}
	
	function ProcessKill($time)
	{
	    $result = mysqli_query($this->Connection, "SHOW FULL PROCESSLIST");
	    while($row=mysqli_fetch_array($result))
	    {
	        $process_id = $row["Id"];
	        if($row["Time"] > $time)
	            mysqli_query($this->Connection, "KILL $process_id");
	    }
	}
	
	function PrintError($erro)
	{
	    ?><div class="col s12">
	    	<div class="card-panel grey lighten-5">
          		<div class="row valign-wrapper">
            		<div class="col s2">
            			<img src="/public/img/layout/error.jpg" alt="" class="circle responsive-img">
            		</div>
                    <div class="col s10">
                      <span class="red-text text-darken-4"><?=$erro?></span>
                    </div>
          		</div>
        	</div>
      	</div><?
      	exit;
	}
}
?>
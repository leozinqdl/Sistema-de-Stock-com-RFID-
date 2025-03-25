<link href="<?=URL_BASE?>/public/css/cssAlert.css" rel="stylesheet" type="text/css" charset="utf-8" />
<meta charset="utf-8"><?php
class AlertJquery
{
	public $n_msn = 0;
	public $msn;
	
	public function addAlert($message)
	{
		$this->msn[$this->n_msn] = "&bull; ".$message;
		$this->n_msn++;
	}
	
	public function printAlert($type_alert, $page_return = null, $action_question = null, $form_action = null)
	{
	    if($page_return)
	        $redirect = "window.location = '".URL_BASE."$page_return';";
        else
            $redirect = "$('.alert_opacity').remove();";

		if($form_action)
		{	
			echo "<script>document.getElementById('$form_action').reset();</script>";
		}
		
		if($type_alert == 1)
		    $this->screenAlert01(URL_BASE.$page_return); //ok
	    elseif($type_alert == 2)
	       $this->screenAlert02($redirect); //erro
       elseif($type_alert == 3)
           $this->screenAlert03($redirect); //aviso
       elseif($type_alert == 4)
           $this->screenAlert04(URL_BASE.$action_question); //pergunta
		
	}
	
	private function screenAlert01($page_return)
	{
        ?><div class="alert_opacity">
			<div class="alert_contant">
    			<div class="alert_title" style="color: #009900"></div><?
				for($i=0; $i<$this->n_msn; $i++) 
				{
					?><div class="alert_mensage"><?=$this->msn[$i]?></div><? 
				}
				?><script>top.parent.location="<?=$page_return?>";</script>
			</div>
		</div><?
	}
	
	private function screenAlert02($redirect)
	{
	    ?><div class="alert_opacity">
			<div class="alert_contant">
    			<div class="bt-fechar"><div onClick="<?=$redirect?>" title="Fechar" class="bt-fechar__bt">X</div></div>
    			<div class="alert_title" style="color: #995555"></div><?
				for($i=0; $i<$this->n_msn; $i++) 
				{
					?><div class="alert_mensage"><?=$this->msn[$i]?></div><? 
				}
			?></div>
		</div><?
	}
	
	private function screenAlert03($redirect)
	{
	    ?><div class="alert_opacity">
			<div class="alert_contant">
    			<div class="bt-fechar"><div onClick="<?=$redirect?>" title="Fechar" class="bt-fechar__bt">X</div></div>
    			<div class="alert_title" style="color: #999933"></div><?
				for($i=0; $i<$this->n_msn; $i++) 
				{
					?><div class="alert_mensage"><?=$this->msn[$i]?></div><? 
				}
			?></div>
		</div><?
	}
	
	private function screenAlert04($action_question)
	{
	    ?><div class="alert_opacity">
			<div class="alert_contant">
    			<div class="alert_title" style="color: #5555DD"></div><?
				for($i=0; $i<$this->n_msn; $i++) 
				{
					?><div class="alert_mensage"><?=$this->msn[$i]?></div><? 
				}
				?><button type="button" class="btn-small waves-effect waves-light bt_confirmar" onclick="javascript: window.location='<?=$action_question?>';">Sim</button>
				<button type="button" class="btn-small waves-effect waves-light bt_cancelar" onclick="$('.alert_opacity').remove();">Não</button><?
			?></div>
		</div><?
	}
	
	public function hasAlert()
	{
		if($this->n_msn > 0)
			return true;
		return false;
	}
	
	public function printScn($color, $icon, $text)
	{
	    ?><div class="col s12">
	    	<div class="card-panel grey lighten-5 z-depth-1">
          		<div class="row valign-wrapper">
                    <div class="col s10">
                      <span class="black-text"><b><?=strtoupper($text)?></b></span>
                    </div>
          		</div>
        	</div>
      </div><?
	}
}
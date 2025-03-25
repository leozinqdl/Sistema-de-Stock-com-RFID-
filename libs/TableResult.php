<?php
class TableResult
{
    private $title_table;
	private $number_column = 0;
	
	public function resultNotFound($print = false)
	{
	    if($print)
	    {
	        $AlertJquery = new AlertJquery();
	        $AlertJquery->addAlert("Nenhum registro encontrado!");
	        $AlertJquery->printAlert(3);
	    }
	    else
	    {
	        ?><center><div class="not-found grey-text text-grey darken-1">Nenhum registro encontrado!</div></center><?
	    }
	}
	
	public function setTitle($title)
	{
	    $this->title_table = $title;
	}
	
	public function headerDraw($vet, $number = null, $ispointer = false, $is_excel = null, $is_txt = null, $is_print = null, $border = 0)
	{
	    session_start();
	    if($_SESSION["xls_sets"] == 1)
	    {
	        ?><center><span style="color: #4242FF; font-weight: bold"><?=utf8_decode(mb_strtoupper($this->title_table))?></span></center>
	        <table border="1">
  			<tr bgcolor="#C0C0C0"><?
		        foreach($vet as $draw)
		        {
		        	?><td style="text-align: center"><b><?=utf8_decode($draw)?></b></td><?
		        	$i++;
		        }
			?></tr><?
			$this->number_column = $i;
	    }
	    else
	    {
    		if($ispointer)
    			$cursor = "style='cursor:pointer;'";
    		?><div class="icons_shortcut"><?
        		if($number)
        		{
        			?><div class="pesquisa_export">Total: <b><?=$number?></b></div><?
        		}
        		if($is_excel)
        		{
        		    if(strpos($is_excel, '/?'))
        		    {
        		        ?><button type="button" class="waves-effect waves-light icons_shortcut_br" name="confirmar" onclick="window.location='<?=URL_BASE?><?=$is_excel?>'">
        		        	<img width="30" src="<?=URL_BASE?>/public/img/layout/excel.png" title="Exportar para o excel"/>
    		        	</button><?
        		    }
    			    else
    			    {
    			        ?><button type="button" class="waves-effect waves-light icons_shortcut_br" name="confirmar" onclick="formSubmitXls('formulario','<?=URL_BASE?><?=$is_excel?>')">
        		        	<img width="30" src="<?=URL_BASE?>/public/img/layout/excel.png" title="Exportar para o excel"/>
    		        	</button><?
    			    }
    			}
    			if($is_txt)
    			{
    			    ?><button type="button" class="waves-effect waves-light icons_shortcut_br" name="confirmar" onclick="formSubmit('formulario','<?=URL_BASE?><?=$is_txt?>')">
    			    	<img width="30" src="<?=URL_BASE?>/public/img/layout/txt.png" title="Exportar para txt"/>
			    	</button><?
    			}
    			if($is_print)
    			{
    			    ?><button type="button" class="waves-effect waves-light icons_shortcut_br" name="confirmar" onclick="window.location='<?=URL_BASE?><?=$is_print?>'">
    			    	<img width="30" src="<?=URL_BASE?>/public/img/layout/print.png" title="Imprimir"/>
			    	</button><?
    			}
    		?></div><?
    			/*
    			 * responsive-table para ficar responsivo.. mas fica na lateral nao gostei.
    			 */
    		?><div class="div_grid_resolution">
    		<table class="highlight striped centered" id="ts" <?=$cursor?> border="<?=$border?>">
    	  		<thead>
        	  		<tr><?
        		        foreach($vet as $draw)
        		        {
        		        	if($draw == "CB_ALL")
        		        	{
        		        		?><th>
        		        			<label class="checkbox_table">
        		        				<input type="checkbox" class="filled-in" id="cboxall" name="cboxall" onclick="javascript:checkAll(this);"/>
        		        				<span></span>
    		        				</label>
    		        			</th><?
        		        	}
        		        	else
        		        	{
        		        		?><th style="text-transform: uppercase; cursor: auto;"><?=$draw?></th><?
        		        	}
        		        	$i++;
        		        }
        			?></tr>
    			</thead><?
    		$this->number_column = $i;	
	    }
	}
	
	public function extraResultDraw($vector)
	{
	    ?><tr><?
			for($i=1; $i<=$this->number_column; $i++)
			{
			    if($vector[$i])
			    {
			        ?><td class="td-no-break" align="center"><i><b><?=$vector[$i]?></b></i></td><?			        
			    }
			    else
			    {
			        ?><td>&nbsp;</td><?
			    }
				
			}
			?>
		</tr><?
	}
	
	public function linkDraw($url, $text, $target)
	{
	    session_start();
	    if($_SESSION["xls_sets"] == 1)
	        $url = IP_SERVER.$url;
	    $target_text = "";
	    if($target)
	        $target_text = "target='_blank'";
        ?><a <?=$target_text?> href="<?=$url?>"><?=$text?></a><?
	}
	
	public function footerDraw($location = false)
	{
		?></table>
		</div><?
		if($location)
		{
			?><script>window.location='#ts';</script><?
		}
		session_start();
		$_SESSION["xls_sets"] = 0;
	}
}
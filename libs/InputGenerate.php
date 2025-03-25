<?php
class InputGenerate
{
    /*--------------------  TITULOS --------------------------*/
    public function titleDraw($title_page,$title_text)
    {
        ?><div class="container_title"><?
            if($title_page)
            {
                ?><div class="title_page"><?=$title_page?></div><?
            }
            if($title_text)
            {
                ?><div class="title_text"><?=$title_text?></div><?
            }
        ?></div><?
    }
    
    /*--------------------  QUEBRA DE TEXTO --------------------------*/
    function textspace($string)
    {
        return "<div style='white-space: normal !important; text-align: justify;'>".nl2br($string)."</div>";
    }
    
    /*--------------------  BOTOES --------------------------*/
    /*
     bt_confirmar   (verde escuro);
     bt_aprovar     (verde);
     bt_cancelar    (roxo);
     bt_excluir     (vermelho);
     bt_devolucao   (verde claro);
     bt_editar      (amarelo);
     bt_pesquisar   (azul escuro);
     bt_gestor      (preto);
     $size          btn-large ou btn-small
     */
    private function buttonWavesEffectDraw($type, $size, $label, $bt_css, $class_icon, $onclick = 0, $link = null, $span_ajax = null, $form = null)
    {
        if(strpos($link, 'http') === false)
            $link_used = URL_BASE.$link;
        else
            $link_used = $link;
        
        if($type == 1)          $type_used = "button";
        elseif($type == 2)      $type_used = "submit";
        elseif($type == 3)      $type_used = "reset";
        
        if($onclick == 0)       $onclick_used = "";
        elseif($onclick == 1)   $onclick_used = "onclick=window.location='$link_used'"; //abre uma pagina na aba local
        elseif($onclick == 2)   $onclick_used = "onclick=\"ajaxJquery('$link_used', '$span_ajax');\"";  //abre um ajax sem formulario
        elseif($onclick == 3)   $onclick_used = "onclick=\"ajaxJquery('$link_used', '$span_ajax', '$form');\""; //abre um ajax com formulario
        elseif($onclick == 4)   $onclick_used = "onclick=window.open('$link_used')";    //abre uma pagina em outra aba
        elseif($onclick == 5)   $onclick_used = "onclick=$('.ajax_opacity').remove();"; //fechar o ajax
        elseif($onclick == 6)   $onclick_used = "onclick=window.history.go(-1)";    //history back
        elseif($onclick == 7)   $onclick_used = "onclick=\"formSubmit('$form', '$link_used');\""; //abre um ajax com formulario
        
        ?><button type="<?=$type_used?>" class="btn-<?=$size?> waves-effect <?=$bt_css?>" <?=$onclick_used?>><?=$label?></button><?
    }
    
    private function buttonWavesEffectSmallDraw($color, $class_icon, $title, $onclick, $link, $span_ajax, $form)
    {
        if(strpos($link, 'http') === false)
            $link_used = URL_BASE.$link;
        else
            $link_used = $link;
            
        if($onclick == 0)
            $href_used = "javascript: formSubmit('$form', '$link_used');";  //abre um ajax sem formulario
        elseif($onclick == 1)
            $href_used = $link_used; //abre uma pagina na aba local
        elseif($onclick == 2)
            $href_used = "javascript: ajaxJquery('$link_used', '$span_ajax');";  //abre um ajax sem formulario
        elseif($onclick == 3)
            $href_used = "javascript: ajaxJquery('$link_used', '$span_ajax', '$form');";  //abre um ajax com formulario
        elseif($onclick == 4)
        {
            $target = "target='_blank'";
            $href_used = $link_used;    //abre uma pagina em outra aba
        }
//         elseif($onclick == 5)   $href_used = "onclick=$('.ajax_opacity').remove();"; //fechar o ajax
//         elseif($onclick == 6)   $href_used = "onclick=window.history.go(-1)";    //history back
//         elseif($onclick == 7)   $href_used = "onclick=\"formSubmit('$form', '$link_used');\""; //abre um ajax com formulario

        
        ?><a class="btn-floating btn-small waves-effect waves-light <?=$color?>" style="margin: 3px;" href="<?=$href_used?>" title="<?=$title?>" <?=$target?>><?
        	if(ctype_upper($class_icon)) //verifica se é maiusculo
        	{
        	    ?><?=$class_icon?><?
        	}
        	else
        	{
        	    ?><i class="material-icons"><?=$class_icon?></i><?
        	    
        	}
    	?></a><?
    }
    
    /*------------------------ BOTOES -------------------------------------*/
    //dinamico
    public function btSmart($size, $label, $materialize_icon, $onclick, $link, $span_ajax = null, $form = null)
    {
        $this->buttonWavesEffectDraw(1, $size, $label, "bt_devolucao", $materialize_icon, $onclick, $link, $span_ajax, $form);
    }
    
    //confirmar
    public function btConfirm($size, $link = null, $span_ajax = null, $form = null)
    {
        if($link)
            $this->buttonWavesEffectDraw(1, $size, "Confirmar", "bt_confirmar", "done", 3, $link, $span_ajax, $form); //para confirmação com ajax
        else
            $this->buttonWavesEffectDraw(2, $size, "Confirmar", "bt_confirmar", "done");  //para confirmação com submit
    }

    //novo
    public function btNew($size, $link, $span_ajax = null)
    {
        if($span_ajax)
            $this->buttonWavesEffectDraw(1, $size, "Adicionar", "bt_aprovar", "playlist_add", 2, $link, $span_ajax); //para confirmação com ajax
        else
            $this->buttonWavesEffectDraw(1, $size, "Adicionar", "bt_aprovar", "playlist_add", 1, $link);  //para confirmação location
    }
    
    //editar
    public function btEdit($size, $link, $span_ajax = null)
    {
        if($span_ajax)
            $this->buttonWavesEffectDraw(1, $size, "Editar", "bt_editar", "edit", 2, $link, $span_ajax);
        else
            $this->buttonWavesEffectDraw(1, $size, "Editar", "bt_editar", "edit", 1, $link);
    }
    
    //excluir
    public function btDelete($size, $link, $span_ajax)
    {
        $this->buttonWavesEffectDraw(1, $size, "Excluir", "bt_excluir", "delete_forever", 2, $link, $span_ajax);
    }
    
    //cancelar
    public function btCancel($size, $link, $span_ajax = null)
    {
        if($span_ajax)
            $this->buttonWavesEffectDraw(1, $size, "Cancelar", "bt_excluir", "close", 2, $link, $span_ajax); //para confirmação com ajax
        else
            $this->buttonWavesEffectDraw(1, $size, "Cancelar", "bt_excluir", "close", 1, $link);  //para confirmação location
    }
    
    //pesquisar
    public function btSearch($size, $link = null)
    {
        if($link)
            $this->buttonWavesEffectDraw(1, $size, "Pesquisar", "bt_pesquisar", "search", 1, $link);  //para pagina visualize
        else
            $this->buttonWavesEffectDraw(2, $size, "Pesquisar", "bt_pesquisar", "search");            //para pagina de pesquisar
    }
    
    //button para history back
    public function btBack($size, $link = null)
    {
        if($link)
            $this->buttonWavesEffectDraw(1, $size, "Retornar", "bt_cancelar", "reply", 1, $link);
        else
            $this->buttonWavesEffectDraw(1, $size, "Retornar", "bt_cancelar", "reply", 6);
    }
    
    //button para resetar formulario
    public function btResetForm()
    {
        $this->buttonWavesEffectDraw(3, "large", "Limpar", "bt_editar", "clear_all");
    }

    //gestor
    public function btGestor($size, $label, $link, $span_ajax = null)
    {
        if($span_ajax)
            $this->buttonWavesEffectDraw(1, $size, $label, "bt_gestor", "fingerprint", 2, $link, $span_ajax); //para confirmação com ajax
        else
            $this->buttonWavesEffectDraw(1, $size, $label, "bt_gestor", "fingerprint", 1, $link);  //para confirmação location
    }
    
    //button para fechar janela ajax
    public function btAjaxClose()
    {
        $this->buttonWavesEffectDraw(3, "large", "Fechar", "bt_cancelar", "close", 5);
    }
    
    public function btFloatingSmall($color, $class_icon, $title, $onclick, $link = null, $span_ajax = null, $form = null)
    {
        $this->buttonWavesEffectSmallDraw("bt_floating_$color", $class_icon, $title, $onclick, $link, $span_ajax, $form);
    }
    
    public function btFloatingSmallDisable($class_icon)
    {
        ?><a class="btn-floating btn-small disabled"><i class="material-icons"><?=$class_icon?></i></a><?
    }
    /*------------------------ FIM BOTOES -------------------------------------*/
    
    
    /*--------------------  INPUT´S --------------------------*/
    //campo texto normal
    public function inputTextDraw($name, $label, $size, $maxlength, $value = null, $onkeyup = null)
    {
        if($value)
            $class_valid = "valid";
        else
            $class_valid = "";
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="text" autocomplete="off" class="validate <?=$class_valid?>" maxlength="<?=$maxlength?>" id="<?=$name?>" name="<?=$name?>" value="<?=$value?>" onkeyup="<?=$onkeyup?>">            
        </div><?
    }
    
    //campo texto com aspas simples para campos que contem aspas no nome
    public function inputAspasDraw($name, $label, $size, $maxlength, $value = null)
    {
        if($value)
            $class_valid = "valid";
        else
            $class_valid = "";
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="text" autocomplete="off" class="validate <?=$class_valid?>" maxlength="<?=$maxlength?>" id="<?=$name?>" name="<?=$name?>" value='<?=$value?>'>            
        </div><?
    }
    
    //campo texto com onchange
    public function inputTextAjaxDraw($name, $label, $size, $onchange, $span, $form)
    {
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="text" autocomplete="off" class="validate" id="<?=$name?>" name="<?=$name?>">
            <a href="javascript: ajaxJquery('<?=$onchange?>', '<?=$span?>', '<?=$form?>');"><i class="material-icons icon-search">search</i></a>    
        </div><?
    }
    
    //campo texto desabilitado
    public function inputTextDisabledDraw($name, $label, $size, $value = null)
    {
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="text" autocomplete="off" class="validate" id="<?=$name?>" name="<?=$name?>" value="<?=$value?>" disabled="disabled">            
        </div><?
    }
   
    //campo texto somente leitura
    public function inputTextReadOnlydDraw($name, $label, $size, $value = null)
    {
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="text" autocomplete="off" placeholder="Nome" class="validate" id="<?=$name?>" name="<?=$name?>"  readonly>            
        </div><?
    }

    //campo texto placeholder
    public function inputTextPlaceholderdDraw($name, $label, $size, $value = null, $palceholder)
    {
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="text" autocomplete="off" class="validate" id="<?=$name?>" placeholder="<?=$palceholder?>" name="<?=$name?>">            
        </div><?
    }
    
    //campo senha
    public function inputPasswordDraw($name, $label, $size)
    {
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="password" autocomplete="off" class="validate" id="<?=$name?>" name="<?=$name?>">            
        </div><?
    }
    
    //campo numerico inteiro
    public function inputNumberDraw($name, $label, $size, $min, $max = null, $value = null)
    {
        if($value)
            $class_valid = "valid";
        else
            $class_valid = "";
        ?><div class="input-field col s<?=$size?>">
            <label for="<?=$name?>"><?=$label?></label>
            <input type="number" autocomplete="off" class="validate <?=$class_valid?>" min="<?=$min?>" max="<?=$max?>" id="<?=$name?>" name="<?=$name?>" value="<?=$value?>">            
        </div><?
    }
    
    //campo data
    public function inputDateDraw($name, $label, $size, $value = null)
    {
        if($value)
            $class_valid = "valid";
        else
            $class_valid = "";
        ?><div class="input-field col s<?=$size?>">
            <input type="date" autocomplete="off" class="validate <?=$class_valid?>" id="<?=$name?>" name="<?=$name?>" value="<?=$value?>">
            <label for="<?=$name?>"><?=$label?></label>            
        </div><?
    }
    
    //campo hora
    public function inputTimeDraw($name, $label, $size, $value = null)
    {
        if($value)
            $class_valid = "valid";
        else
            $class_valid = "";
        ?><div class="input-field col s<?=$size?>">
            <input type="time" autocomplete="off" class="validate <?=$class_valid?>" id="<?=$name?>" name="<?=$name?>" value="<?=$value?>">
            <label for="<?=$name?>"><?=$label?></label>            
        </div><?
    }
    
    //campo textarea
    public function inputTextareaDraw($name, $label, $size, $value = null)
    {
        if($value)
            $class_valid = "valid";
        else
            $class_valid = "";
        ?><div class="input-field col s<?=$size?>">
        	<label for="<?=$name?>"><?=$label?></label>
        	<textarea id="<?=$name?>" name="<?=$name?>" class="materialize-textarea validate <?=$class_valid?>"><?=$value?></textarea>        	
        </div><?
    }
    
    //campo upload de arquivos
    public function inputFileDraw($name, $is_multiple = true, $label = null)
    {
        if($is_multiple)
            $multiple = "multiple";
        else
            $multiple = "";
        
        if($label == null)
            $label = "Arquivos"

        ?><div class="file-field input-field">
            <div class="btn"><span><?=$label?></span><input name="<?=$name?>" type="file" <?=$multiple?>></div>
            <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Upload de um ou mais arquivos">
            </div>
        </div><?
    }
    
    //campo select
    public function inputSelectDraw($name, $label, $size, $options, $selected = null, $onchange = null, $span = null, $form = null, $onchange2 = null, $span2 = null, $disabled = false)
    {
        if($selected)
            $class_valid = "valid";
        else
            $class_valid = "";
        
        if($disabled)
            $disabled_text = "disabled";
        else
            $disabled_text = "";
            
        ?><div class="input-field col s<?=$size?>"><?
            if($onchange)
            {
                ?><select searchable='&nbsp;' id="SelectSearch" id="<?=$name?>" name="<?=$name?>" class="select validate <?=$class_valid?>" onchange="ajaxJqueryListing('<?=URL_BASE?><?=$onchange?>', '<?=$span?>', '<?=$form?>'); ajaxJqueryListing('<?=URL_BASE?><?=$onchange2?>', '<?=$span2?>', '<?=$form?>');"><?
            }
            else
            {
                ?><select searchable='&nbsp;' id="SelectSearch" name="<?=$name?>" class="select validate <?=$class_valid?>"><?
            }
            ?><option value="" <?=$disabled_text?> selected>Selecione</option><?
            foreach($options as $key => $value)
            {
                if($selected != null)
                {
                    if($selected == $key)
                    {
                        ?><option value="<?=$key?>" selected="selected"><?=$value?></option><?
                	}
                	else
                	{
                	    ?><option value="<?=$key?>"><?=$value?></option><?
                	}
                }
                else
                {
                    ?><option value="<?=$key?>"><?=$value?></option><?
                }
            }
            ?></select>
            <label><?=$label?></label>
        </div>
        <script type="text/javascript">
	        var elemsSelect = document.querySelectorAll('select');
    		var instances = M.FormSelect.init(elemsSelect, {
    			classes: 'select'
    		});
		</script><?
    }
    
    public function inputSelectMultipleDraw($name, $label, $size, $options, $vet_selected = null)
    {
        ?><div class="input-field col s<?=$size?>">
            <select name="<?=$name?>" multiple searchable='&nbsp;' id="SelectSearchMultiple" class="select validate">
            <option value="" disabled>Selecione</option><?
            foreach($options as $key => $value)
            {
                if($vet_selected != null)
                {
                    if(in_array($key, $vet_selected))
                    {
                        ?><option value="<?=$key?>" selected="selected"><?=$value?></option><?
                    }
                    else
                    {
                        ?><option value="<?=$key?>"><?=$value?></option><?
                    }
                }
                else
                {
                    ?><option value="<?=$key?>"><?=$value?></option><?
                }
            }
            ?></select>
            <label><?=$label?></label>
        </div>
        <script type="text/javascript">
            var elemsSelect = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elemsSelect, {
                classes: 'select'
            });
        </script>
        <?
    }
    
    
    /* ----------------------------------- radio --------------------------------------------*/
    //usado para alterar status em geral
    public function inputRadioDraw($name, $options, $value_check = null)
    {
    	foreach($options as $key => $value)
    	{
    	    if($value_check == $key)
    	        $checked_input = "checked='checked'";
    	    else
    	        $checked_input = "";
    	    ?><span class="radio-fields">
    	    	<label><input class="with-gap" id="<?=$name?>" name="<?=$name?>" type="radio" value="<?=$key?>" <?=$checked_input?> /><span class="radio_padding"><?=mb_strtoupper($value)?></span></label>
        	</span><?
    	}
    }
    
    //usado na criacao de grupos e permissoes e na pagina de aprovacao das cotacoes de compras
    public function inputRadioList($value, $name, $span, $checked = false, $disabled = false)
    {
        if($checked == true)
            $checked_input = "checked='checked'";
        if($disabled == true)
            $disabled_input = "disabled='disabled'";
        ?><label>
        	<input class="with-gap" id="<?=$name?>" name="<?=$name?>" type="radio" value="<?=$value?>" <?=$checked_input?> <?=$disabled_input?>/>
        	<span class="radio_padding"><?=$span?></span>
    	</label><?
    }
    /* -------------------------------- fim radio --------------------------------------------*/
    
    
    /* ----------------------------------- checkbox --------------------------------------------*/
    //usado no pesquisa para os status
    public function inputCheckboxDraw($name, $options)
    {
        ?><div class="checkbox-messages"><?
        foreach($options as $key => $value)
        {
            $key_ex = explode("-", $key);
            if($key_ex[1] == "check")
                $checked_text = "checked='checked'";
            else
                $checked_text = "";
            ?><label class="checkbox_pernalizado" title="<?=$value?>">
            	<input type="checkbox" class="filled-in" name="<?=$name?>" value="<?=$key_ex[0]?>" <?=$checked_text?>/>
                <span class="check_options"><?=mb_strtoupper($value)?></span>
        	</label><?
        }
        ?></div><?
    }
    
    //usado nas tabelas
    public function inputCheckboxList($value, $name, $label = null, $url = null, $checked = false, $disable = false)
    {
        session_start();
        if($_SESSION["xls_sets"] == 1)
        {
            if($label)
            {
                ?><?=$label?><?
			}
			else
			{
			    ?>-<?
			}
	    }
	    else
	    {
	        if($checked == true)
	            $checked_input = "checked='checked'";
	        
            if($disable == true)
                $disabled_input = "disabled='disabled'";
                
            ?><label class="checkbox_table">
            	<input type="checkbox" class="filled-in" name="<?=$name?>" value="<?=$value?>" <?=$disabled_input?> <?=$checked_input?>/><?
				if($url)
				{
				    ?><span class="check_options"><a target="_blank" href="<?=URL_BASE?><?=$url?>"><b><?=$label?></b></a></span><?
				}
				else
				{
				    ?><span><?=$label?></span><?
				}
			?></label><?
	    }
	}
}
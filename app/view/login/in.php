<?php
$InputGenerate = new InputGenerate();
?><form id="formulario" class="login_login">
	<div id="span_destiny"></div>
    <img class="login_logo" src="<?=URL_BASE?>/public/img/layout/logo-fazenda-mandaguari.png">
      <div class="row">
      	<div class="input-field col s12">
      		<input id="icon_prefix" type="text" class="validate" name="user_name"><label for="icon_prefix">Usuário</label>
        </div>
        </div>
        <div class="row">
        	<div class="input-field col s12">
        		<input id="icon_telephone" type="password" class="validate" name="user_pass"><label for="icon_telephone">Senha</label>
    		</div>
      </div><?
      $InputGenerate->btConfirm("large","/login/in", "span_destiny", "formulario");
?></form>
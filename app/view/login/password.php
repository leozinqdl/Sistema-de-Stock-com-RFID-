<?php
$InputGenerate = new InputGenerate();
?><div class="container_pages"><?
$InputGenerate->titleDraw("usuários","trocar senha");
?><div id="span_destiny"></div>
	<form id="formulario" class="col s12">
	<section>
		<div class="section-legend">Dados em geral</div>
		<div class="row"><?
		$InputGenerate->inputPasswordDraw("password", "Atual", 4);
		$InputGenerate->inputPasswordDraw("new_password", "Nova", 4);
		$InputGenerate->inputPasswordDraw("new_password_confirm", "Confirmar", 4);
		?></div>
		
	</section>
    <div class="conteiner_bt_actions"><?
    $InputGenerate->btConfirm("large","/login/password", "span_destiny", "formulario");
    $InputGenerate->btBack("large");
    ?></div>
    </form>
</div>
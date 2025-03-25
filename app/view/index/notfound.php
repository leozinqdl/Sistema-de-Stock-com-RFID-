<?php
$InputGenerate = new InputGenerate();
?><div class="container_pages"><?
$InputGenerate->titleDraw("Colaborador não encontrado!","Colaborador inativo, ou não registrado na base de dados!");
?><center><img src="<?=URL_BASE?>/public/img/layout/notfound.png"></center>
<div class="conteiner_bt_actions"><?
$InputGenerate->btBack("large","/index");
?></div>
</div>
<?php
$InputGenerate = new InputGenerate();
?><div class="container_pages"><?
$InputGenerate->titleDraw("Acesso não permitido!","Entre em contato com o administrador do sistema.");
?><div id="span_destiny"></div>
<center><img src="<?=URL_BASE?>/public/img/layout/notpermission.png"></center>
<div class="conteiner_bt_actions"><?
$InputGenerate->btBack("large","/index");
?></div>
</div>
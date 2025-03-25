<?php
$InputGenerate = new InputGenerate();
?><div class="container_pages"><?
$msg_fail = $vetdatabase["msg_fail"];
if($msg_fail == 1)
    $text_error = "Colaborador não encontrado, inativo, ou não registrado na base de dados!";
elseif($msg_fail == 2)
    $text_error = "Esse colaborador não possui permissão para almoçar!";
elseif($msg_fail == 3)
    $text_error = "Esse colaborador não possui permissão para jantar!";
elseif($msg_fail == 4)
    $text_error = "Esse colaborador ou visitante já possui 2(dois) lançamentos na mesma data!";
elseif($msg_fail == 5)
    $text_error = "Esse colaborador ou visitante possui registro a menos de 3(três) horas!";
elseif($msg_fail == 6)
    $text_error = "Visitante prestador não encontrado, ou periodo de tempo finalizado.";
    
$InputGenerate->titleDraw("Erro!", $text_error);
?><center><img src="<?=URL_BASE?>/public/img/layout/notfound.png"></center>
<div class="conteiner_bt_actions"><?
$InputGenerate->btBack("large","/dininghall/insert01");
?></div>
</div>
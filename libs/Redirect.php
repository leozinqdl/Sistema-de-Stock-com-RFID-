<?php
class Redirect
{
    public function redirectDraw($backgoundColor, $hoverColor, $name, $icon, $target, $url)
    {
        if($target == "on")
            $a_target = "target='_blank'";
      
        if(!$backgoundColor)
        $backgoundColor = "#e6e6e6";

        if(!$hoverColor)
        $hoverColor = "";
            
        ?><a <?=$a_target?> style="text-decoration:none; text-transform:uppercase"
        onMouseOut="this.style.backgroundColor='<?=$backgoundColor?>'" href="<?=URL_BASE.$url?>">
        	<div onMouseOut="this.style.borderColor='<?=$hoverColor?>'" class="cardImgItem"><img  class="cardImg" src="<?=URL_BASE?>/public/img/layout/<?=$icon?>.png"><?=$name?></div>
        </a><?
    }
    public function redirectDrawList($backgoundColor, $hoverColor, $name, $icon, $target, $url)
    {
        if($target == "on")
            $a_target = "target='_blank'";
      
        if(!$backgoundColor)
        $backgoundColor = "#e6e6e6";

        if(!$hoverColor)
        $hoverColor = "";
            
        ?><a <?=$a_target?> style="text-decoration:none;  text-transform: uppercase;"
        onMouseOut="this.style.backgroundColor='<?=$backgoundColor?>'" href="<?=URL_BASE.$url?>">
        	<div onMouseOut="this.style.borderColor='<?=$hoverColor?>'" ><?=$name?></div>
        </a><?
    }
}
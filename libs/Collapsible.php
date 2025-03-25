<?php
class Collapsible
{
    /*
     * Tipos:
     * expandable
     * popout
     */
    public function collapsibleBegin($type = null)
    {
        ?><ul class="collapsible <?=$type?>"><?
    }
    
    public function collapsibleEnd()
    {
        ?></ul><?
    }
    
    public function collapsibleHeader($name, $icon, $badge = null, $color_badge = null, $data_badge = null, $li_active = "")
    {
        ?><li class="<?=$li_active?>">
            <div class="collapsible-header">
            	<i class="material-icons"><?=$icon?></i><?=mb_strtoupper($name)?><?
            	if($badge)
            	{
            	    ?><span class="new badge <?=$color_badge?>" data-badge-caption="<?=$data_badge?>"><?=$badge?></span><?
            	}
        	?></div>
        	<div class="collapsible-body"><?
    }
    
    public function collapsibleFooter()
    {
        ?></div></li><?
    }
}
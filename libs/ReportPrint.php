<?php
class ReportPrint
{
    public function begin()
    {
        ?><div class="quebrapagina"><?
    }
    
    public function end()
    {
        ?></div><?
    }
    
    public function header($url_qrcode = null)
    {
        ?><div class="header-print">
            <div class="logo"></div><? 
            if($url_qrcode)
            {
                ?><div>
                	<img src='https://chart.googleapis.com/chart?cht=qr&chl=<?=IP_SERVER?><?=urlencode($url_qrcode)?>&chs=128x128&choe=UTF-8&chld=L|2'>
            	</div><?
            }
        ?></div><?
    }
    
    public function title($title)
    {
        ?><div class="titulo"><?=$title?></div><?
    }
    
    public function subtitle($subtitle)
    {
        ?><div class="subtitulo"><?=$subtitle?></div><?
    }
    
    public function signature($vet_signatures)
    {
        $number_cols = count($vet_signatures);
        ?><table>
            <tr><?
                for ($i=1; $i <= $number_cols; $i++)
                {
                    ?><td style="border: none;" align="center">______________________________________</td><? 
                }
            ?></tr>
            <tr><?
                foreach ($vet_signatures as $signatures)
                {
                    ?><td style="border: none;" align="center"><?=$signatures?></td><? 
                }
            ?></tr>
    	</table><?
    }
}
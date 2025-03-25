<link href="/public/css/calendar.css" rel="stylesheet" type="text/css" charset="utf-8" />
<?php
class calendarDraw
{
    function calendarShow($month, $year)
    {
        $form = new FormValidate();
        $extensive_month = $form->str_extensive_months($month);
        $primeiro_dia = mktime(0, 0, 0, $month, 1, $year); //vamos obter o primeiro dia do calendário
        $dias_mes = date('t', $primeiro_dia); //obtém a quantidade de dias no mês
        $dia_inicio = date('w', $primeiro_dia); //dia da semana que o calendário inicia (começa em 0)

        ?><div class="relogio__ano"><?=$extensive_month?> de <?=$year?></div>
        <table class="highlight centered" border="1">
      		<thead>
      		<tr>
      			<td align="center">DOM</td>
      			<td align="center">SEG</td>
      			<td align="center">TER</td>
      			<td align="center">QUA</td>
      			<td align="center">QUI</td>
      			<td align="center">SEX</td>
      			<td align="center">SAB</td>
  			</tr>
  			</thead>
            <tr><?
            //precisamos de células vazias até encontrarmos o dia inicial da semana
            if($dia_inicio > 0)
            {
                for($i = 0; $i < $dia_inicio; $i++)
                {
                    ?><td>&nbsp;</td><?
                }
            }
            //agora já podemos começar a preencher o calendário
            for($dia = 1; $dia <= $dias_mes; $dia++ )
            {
                $dt_calendar_php = $year."-".$month."-".$dia;
                if($dia_inicio == 0)
                {
                    //vamos colorir o domingo de vermelho
                    $estilo = "red";
                }
                else
                    $estilo = "";
              // vamos colocar a data de hoje sublinhada
              if(($dia == date("j")) && ($month == date("n")) && ($year == date("Y")))
              {
                  ?><td class="relogio__datatoday" align="center" style="cursor: pointer;" onclick="ajaxJqueryFast('/calendar/listall/?dt_calendar=<?=$dt_calendar_php?>', 'span_header_ajax');"><?=$dia?></td><?
              }
              else
              {
                  ?><td style="cursor: pointer; color: <?=$estilo?>" align="center" onclick="ajaxJqueryFast('/calendar/listall/?dt_calendar=<?=$dt_calendar_php?>', 'span_header_ajax');"><?=$dia?></td><?
              }
              // vamos incrementar o dia de referência
              $dia_inicio++;
              // já precisamos adicionar uma nova linha na tabela?
              if($dia_inicio == 7)
              {
                  $dia_inicio = 0;
                  ?></tr><?
                  if($dia < $dias_mes)
                  {
                      ?><tr><?
                  }
              }
          }
      // agora preenchemos as células restantes
      if($dia_inicio > 0)
      {
          for($i = $dia_inicio; $i < 7; $i++)
          {
              ?><td>&nbsp;</td><?
          }
          
          ?></tr><?
      }
      ?></table><?
    }
}
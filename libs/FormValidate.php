<?php
class FormValidate
{
	/*-------------------- MANIPULACAO DE DATAS E HORAS --------------------------*/
	/*
	 * Converte uma sequencia de numeros em data formato br.
	 * result exemple = xx/xx/xxxx.
	 */
	function dt_str_to_date($string)
	{
	    $dt_point_d = substr($string, 0, -6);
	    $dt_point_m = substr($string, 2, -4);
	    $dt_point_y = substr($string, 4);
	    return $dt_point_d."/".$dt_point_m."/".$dt_point_y;
	}

	/*
	 * Converte uma sequencia de numeros em horas.
	 * result exemple = xx:xx.
	 */
	function dt_str_to_hr($string)
	{
	    $hora_1 = substr( $string, 0, 2);
	    $hora_2 = substr( $string, 2);
	    return $hora_1.":".$hora_2;
	}

	/*
	 * Retorna a conversao de horas para numeros.
	 * $hr = campo horas no formato xx:xx.
	 * result exemple = 100.
	 */
	function dt_hr_to_number($hr)
	{
	    $hr_ex = explode (":", $hr);
	    $value = $hr_ex[1]/60;
	    if($hr_ex[0] > 0)
	        return $value + $hr_ex[0];
        return $value;
	}

	/*
	 * Retorna a conversao de horas para minutos.
	 * $hr = campo horas no formato xx:xx.
	 * result exemple = 100.
	 */
	function dt_hr_to_min($hr)
	{
	    if($this->time_validade($hr))
	    {
    		$hr_ex = explode (":", $hr);
    		return (($hr_ex[0] * 60) + $hr_ex[1]);
	    }
	    else
	        return 0;
	}

	/*
	 * Retorna a conversao de minutos para horas.
	 * $mins = campo horas no formato xxx.
	 * result exemple = xx:xx.
	 */
	function dt_min_to_hr($mins)
	{
		$min = abs($mins); //transforma o numero em positivo

		// Arredonda a hora
		$h = floor($min / 60);
		$m = ($min - ($h * 60)) / 100;
		$horas = $h + $m;

		// Separa a hora dos minutos
		$sep = explode('.', $horas);
		$h = $sep[0];
		if (empty($sep[1]))
			$sep[1] = 00;
		$m = $sep[1];
		// Aqui um pequeno artifício pra colocar um zero no final
		if (strlen($m) < 2)
			$m = $m . 0;
		$value_hours = sprintf('%02d:%02d', $h, $m);
		if($mins < 0)
			$value_hours = "- $value_hours";
		return $value_hours;
	}

	/*
	 * Retorna o ultimo dia do mes informado.
	 * $month = mês informado.
	 * $year = ano informado.
	 * result exemple = 30.
	 */
	function dt_last_day_month($month, $year)
	{
		return date("t", mktime(0,0,0,$month,'01',$year));
	}

	/*
	 * Retorna uma data valida, apartir do mes e ano informado.
	 * $month = mês informado.
	 * $year = ano informado.
	 * $type = 1 para inicio e 2 para dia final do mes.
	 * result exemple = xx/xx/xxxx.
	 */
	function dt_generate($month, $year, $type)
	{
	    if($type == 1)
	        return "01/".$month."/".$year;
        elseif($type == 2)
	        return $this->dt_last_day_month($month, $year)."/".$month."/".$year;
	}

	/*
	 * Retorna o resultado da remocao de x dias de uma determinada data.
	 * $date_br = data no formato brasileiro xx/xx/xxxx.
	 * $day = dia(s) a ser removido.
	 * result exemple = xx/xx/xxxx.
	 */
	function dt_remove_day($date_br, $day)
	{
	    if($date_br)
	    {
    	    if(strpos($date_br, "-") == 4)
    	        $date_br = $this->db_date($date_br);

    		$dt = explode("/",$date_br);
    		return date("d/m/Y", mktime(0,0,0, $dt[1], $dt[0]-$day, $dt[2]));
	    }
	    else
	        return 0;
	}

	/*
	 * Retorna o resultado da remocao de x anos de uma determinada data.
	 * $date_br = data no formato brasileiro xx/xx/xxxx.
	 * $year = ano(s) a ser removido.
	 * result exemple = xx/xx/xxxx.
	 */
	function dt_remove_year($date_br, $year)
	{
	    if(strpos($date_br, "-") == 4)
	        $date_br = $this->db_date($date_br);

	    $dt = explode("/",$date_br);
	    return date("d/m/Y", mktime(0,0,0, $dt[1], $dt[0], $dt[2]-$year));

	}

	/*
	 * Retorna o resultado da adicao de x dias de uma determinada data.
	 * $date_br = data no formato brasileiro xx/xx/xxxx.
	 * $day = dia(s) a ser acrescentado.
	 * $type_contract = geralmente false, mas se true, retorna o dia adicionado menos um pois os contratos dos colaborador
	 * sao contabilizados assim.
	 * result exemple = xx/xx/xxxx.
	 */
	function dt_add_day($date_br, $day, $type_contract = false)
	{
	    if(strpos($date_br, "-") == 4)
	        $date_br = $this->db_date($date_br);

		$dt = explode("/",$date_br);
		if($type_contract)
			return date("d/m/Y", mktime(0,0,0, $dt[1], $dt[0]+$day-1, $dt[2]));
		else
			return date("d/m/Y", mktime(0,0,0, $dt[1], $dt[0]+$day, $dt[2]));
	}

	function dt_add_month($date_br, $month)
	{
	    $dt = explode("/",$date_br);
        return date("d/m/Y", mktime(0,0,0, $dt[1]+$month, $dt[0], $dt[2]));
	}

	function dt_add_year($date_br, $year)
	{
	    $dt = explode("/",$date_br);
	    return date("d/m/Y", mktime(0,0,0, $dt[1], $dt[0], $dt[2]+$year));
	}
	
	/*
	 * Retorna o resultado da adicao de x dias uteis de uma determinada data.
	 * $date_br = data no formato brasileiro xx/xx/xxxx.
	 * $day = dia(s) uteis a ser acrescentado.
	 * result exemple = xx/xx/xxxx.
	 */
	function dt_add_dayworking($date_br, $days)
	{
		$new_dt = $date_br;
		for($i=1; $i<=$days; $i++)
		{
			$new_dt = $this->dt_add_day($new_dt, 1);
			if($this->dt_weekday($new_dt) == 6)
				$new_dt = $this->dt_add_day($new_dt, 1);
			if($this->dt_weekday($new_dt) == 0)
				$new_dt = $this->dt_add_day($new_dt, 1);
		}
		return $new_dt;
	}
	
	/*
	 * Retorna a diferenca em dias entre duas datas, podendo ser somente datas ou datas e horas.
	 * $data_maior = data no formato brasileiro xx/xx/xxxx.
	 * $data_menor = data no formato brasileiro xx/xx/xxxx.
	 */
	function dt_difference_days($data_maior, $data_menor, $type_return = 1)
	{
	    if(strpos($data_maior, "-") == 4)
	        $data_maior = $this->db_date($data_maior);
	        
        if(strpos($data_menor, "-") == 4)
            $data_menor = $this->db_date($data_menor);
	    
	    $dt_maior_ex = explode(" ", $data_maior);
	    $dt_maior = $dt_maior_ex[0];
	    $hr_maior = explode (".", $dt_maior_ex[1]);
	    $hr_maior = explode (":", $hr_maior[0]);
	    $dt_maior_ex2 = explode("/",$dt_maior);
	    
	    $dt_menor_ex = explode(" ", $data_menor);
	    $dt_menor = $dt_menor_ex[0];
	    $hr_menor = explode (".", $dt_menor_ex[1]);
	    $hr_menor = explode (":", $hr_menor[0]);
	    $dt_menor_ex2 = explode("/",$dt_menor);
	    
	    $timestamp1 = mktime($this->int_zero_db($hr_maior[0]),$this->int_zero_db($hr_maior[1]),0,$dt_maior_ex2[1],$dt_maior_ex2[0],$dt_maior_ex2[2]);
	    $timestamp2 = mktime($this->int_zero_db($hr_menor[0]),$this->int_zero_db($hr_menor[1]),0,$dt_menor_ex2[1],$dt_menor_ex2[0],$dt_menor_ex2[2]);
	    
	    $differenceSecund = $timestamp1 - $timestamp2;
	    $days = round(($differenceSecund/60/60/24));
	    $hrs = round(($differenceSecund/60/60));
	    $mins = round(($differenceSecund/60));
	    
	    if($type_return == 1)
	        return $days;
        elseif($type_return == 2)
	        return $hrs;
        elseif($type_return == 3)
	        return $mins;
	}
	
	/*
	 * Retorna a representacao numerica do dia da semana. 0 (para domingo) até 6 (para sábado).
	 * $date_br = data no formato brasileiro xx/xx/xxxx.
	 * result exemple = de 0 a 6.
	 */
	function dt_weekday($dt_br)
	{
		$dt_br_ex = explode("/", $dt_br);
		return date("w", mktime(0,0,0,$dt_br_ex[1], $dt_br_ex[0], $dt_br_ex[2]));
	}
	
	/*
	 * Retorna o dia da semana ja formatado.
	 */
	function dt_weekday_print($day)
	{
	    switch($day)
	    {
	        case"0": $diasemana = "Dom";	break;
	        case"1": $diasemana = "Seg";	break;
	        case"2": $diasemana = "Ter";	break;
	        case"3": $diasemana = "Qua";	break;
	        case"4": $diasemana = "Qui";	break;
	        case"5": $diasemana = "Sex";	break;
	        case"6": $diasemana = "Sab";	break;
	    }
	    return $diasemana;
	}
	
	/*
	 * Retorna o numero da semana referente ao ano informado na data.
	 * $date_br = data no formato brasileiro xx/xx/xxxx.
	 * result exemple = 25.
	 */
	function dt_weekday_year($date_br)
	{
		$dt_weekday = $this->dt_weekday($date_br);
		$date_ex = explode("/", $date_br);
		$week_years = date("W", mktime(0,0,0,$date_ex[1],$date_ex[0],$date_ex[2]));
		if($dt_weekday == 0)
		{
			if($week_years > 51) //senao ele soma uma semana inexistente para o ano.
				return 1;
			else
				return intval($week_years+1); //isso pq a funçao 'W' returna o numero da semana começando na segunda, mas na verdade precisa ser no domingo.
		}
		return intval($week_years);
	}
	
	/*
	 * Retorna um array com o numero da semana concatenado com o ano equivaliente.
	 * $dt_ini_br = data de inicio no formato brasileiro xx/xx/xxxx.
	 * $dt_end_br = data de termino no formato brasileiro xx/xx/xxxx.
	 * result exemple: 25_2018 - 26_2018 - 27_2018.
	 */
	
	function dt_weekday_year_array($dt_ini_br, $dt_end_br)
	{
	    if(strpos($dt_ini_br, "-") == 4)
	        $dt_ini_br = $this->db_date($dt_ini_br);
	        
        if(strpos($dt_end_br, "-") == 4)
            $dt_end_br = $this->db_date($dt_end_br);
	        
		$dif_days = $this->dt_difference_days($dt_end_br, $dt_ini_br);
		$dt_ini_ex = explode("/", $dt_ini_br);
		for($i=0; $i<=$dif_days; $i++)
			$vet_element[] = date("d/m/Y", mktime(0,0,0, $dt_ini_ex[1], $dt_ini_ex[0]+$i, $dt_ini_ex[2]));
			
		foreach ($vet_element as $periodic)
		{
			$periodic_ex = explode("/", $periodic);
			$weeks_value = $this->dt_weekday_year($periodic)."_".$periodic_ex[2];
			$weeks[] = $weeks_value;
		}
		return array_unique($weeks);
	}
	
	/*
	 * Retorna uma matriz contendo o primeiro dia da semana, em conjunto com a funcao,
	 * dt_weekday_year_array pegando seu resultado e colocando em vetores de elementos.
	 * $dt_ini_br = data de inicio no formato brasileiro xx/xx/xxxx.
	 * $dt_end_br = data de termino no formato brasileiro xx/xx/xxxx.
	 * result exemple: 22/06/2018 - 24/06/2018 - 01/07/2018.
	 */
	function dt_weekday_year_matrix($dt_ini_br, $dt_end_br)
	{
	    if(strpos($dt_ini_br, "-") == 4)
	        $dt_ini_br = $this->db_date($dt_ini_br);
	        
        if(strpos($dt_end_br, "-") == 4)
            $dt_end_br = $this->db_date($dt_end_br);
	        
		$dif_days = $this->dt_difference_days($dt_end_br, $dt_ini_br);
		$dt_ini_ex = explode("/", $dt_ini_br);
		for($i=0; $i<=$dif_days; $i++)
			$vet_element[] = date("d/m/Y", mktime(0,0,0, $dt_ini_ex[1], $dt_ini_ex[0]+$i, $dt_ini_ex[2]));
			
		foreach ($vet_element as $periodic)
		{
			$periodic_ex = explode("/", $periodic);
			$weeks_value = $this->dt_weekday_year($periodic)."_".$periodic_ex[2];
			$vet_element_W[$weeks_value][] = $periodic;
			$weeks[] = $weeks_value;
		}
		$weeks_number = array_unique($weeks);
		foreach ($weeks_number as $periodic)
		{
			$vet_element_new[$periodic][] = array_shift($vet_element_W[$periodic]);
			$vet_element_new[$periodic][] = array_pop($vet_element_W[$periodic]);
		}
		return $vet_element_new;
	}
	
	/*
	 * Retorna um array contendo todas as datas entre a data de inicio e a data final.
	 * $dt_ini_br = data de inicio no formato brasileiro xx/xx/xxxx.
	 * $dt_end_br = data de termino no formato brasileiro xx/xx/xxxx.
	 * result exemple: 20/06/2018 - 21/06/2018 - 22/06/2018....
	 */
	function dt_between_array($dt_ini, $dt_end)
	{
	    if(strpos($dt_ini, "-") == 4)
	        $dt_ini = $this->db_date($dt_ini);
	    
        if(strpos($dt_end, "-") == 4)
            $dt_end = $this->db_date($dt_end);
	    
        $dif_days = $this->dt_difference_days($dt_end, $dt_ini);
        $dt_ex = explode("/", $dt_ini);
	    
	    for($i=0; $i<=$dif_days; $i++)
	        $array_between[] = date("d/m/Y", mktime(0,0,0, $dt_ex[1], $dt_ex[0]+$i, $dt_ex[2]));
	        
	    return $array_between;
	}
	
	function dt_between_week_array($dt_ini_br, $dt_end_br)
	{
	    if(strpos($dt_ini_br, "-") == 4)
	        $dt_ini_br = $this->db_date($dt_ini_br);
	        
        if(strpos($dt_end_br, "-") == 4)
            $dt_end_br = $this->db_date($dt_end_br);
	        
	    $vet_element = $this->dt_between_array($dt_ini_br, $dt_end_br);
	    
	    //gerando as datas semanais
	    foreach ($vet_element as $periodic)
	    {
	        $periodic_ex = explode("/", $periodic);
	        $weeks_value = $this->dt_weekday_year($periodic)."_".$periodic_ex[2];
	        $vet_element_W[$weeks_value][] = $periodic;
	        $weeks[] = $weeks_value;
	    }
	    $weeks_number = array_unique($weeks);
	    foreach ($weeks_number as $periodic)
	    {
	        $vet_element_new[$periodic][] = array_shift($vet_element_W[$periodic]);
// 	        $vet_element_new[$periodic][] = array_pop($vet_element_W[$periodic]);
	    }
	    
	    foreach ($weeks_number as $periodic)
	    {
	        $return[] = array_shift($vet_element_new[$periodic]);
// 	        $return[] = array_pop($vet_element_new[$periodic]);
	    }
	    return $return;
	}
	
	function dt_between_month_array($dt_ini_br, $dt_end_br)
	{
	    if(strpos($dt_ini_br, "-") == 4)
	        $dt_ini_br = $this->db_date($dt_ini_br);
	        
        if(strpos($dt_end_br, "-") == 4)
            $dt_end_br = $this->db_date($dt_end_br);
	        
	    $vet_element = $this->dt_between_array($dt_ini_br, $dt_end_br);
	    
	    //gerando as datas
	    foreach ($vet_element as $periodic)
	    {
	        $periodic_ex = explode("/", $periodic);
	        $weeks_value = $periodic_ex[1]."_".$periodic_ex[2];
	        $vet_element_W[$weeks_value][] = $periodic;
	        $weeks[] = $weeks_value;
	    }
	    $weeks_number = array_unique($weeks);
	    foreach ($weeks_number as $periodic)
	        $vet_element_new[$periodic][] = array_shift($vet_element_W[$periodic]);
	    
	    foreach ($weeks_number as $periodic)
	        $return[] = array_shift($vet_element_new[$periodic]);
	    
	    return $return;
	}
	
	function dt_workload($vethr)
	{
	    $vethr_filter = array_filter($vethr); //retirar valores nulos do array;
	    $wk_final = 0; //inicia variavel com valor 0;
	    $vethr_chunk = array_chunk($vethr_filter, 2); //Divide um array em pedaços (no caso em 2 partes);
	    
	    for($i=0; $i<count($vethr_chunk); $i++)
	    {
	        $hour_ini = $this->dt_hr_to_min($vethr_chunk[$i][0]);
	        $hour_end = $this->dt_hr_to_min($vethr_chunk[$i][1]);
	        
	        if($hour_ini < $hour_end)
	            $wk = abs($hour_ini - $hour_end);
            else
                $wk = abs($hour_ini - ($hour_end+1440));
	                
            $wk_final += $wk;
	    }
	    return $this->dt_min_to_hr($wk_final);
	}	
	
	function dt_age($date_br)
	{
	    if(strpos($date_br, "-") == 4)
	        $date_br = $this->db_date($date_br);
	    $data = explode("/", $date_br);
	    $diab = $data[0];
	    $mesb = $data[1];
	    $anob = $data[2];
	    list ($dia,$mes,$ano) = explode("/",date("d/m/Y"));
	    $idade = $ano-$anob;
	    $idade = (($mes<$mesb) OR (($mes==$mesb) AND ($dia<$diab))) ? --$idade : $idade;
	    return $idade;
	}
	
	function dt_month_array()
	{
	    $vet_month["01"] = "Janeiro";
	    $vet_month["02"] = "Fevereiro";
	    $vet_month["03"] = "Março";
	    $vet_month["04"] = "Abril";
	    $vet_month["05"] = "Maio";
	    $vet_month["06"] = "Junho";
	    $vet_month["07"] = "Julho";
	    $vet_month["08"] = "Agosto";
	    $vet_month["09"] = "Setembro";
	    $vet_month["10"] = "Outubro";
	    $vet_month["11"] = "Novembro";
	    $vet_month["12"] = "Dezembro";
	    return $vet_month;
	}
	
	function dt_days_with_month_array()
	{
	    $vet_month["0"] = "Sem periodo";
	    $vet_month["90"] = "3 meses";
	    $vet_month["180"] = "6 meses";
	    $vet_month["365"] = "1 ano";
	    $vet_month["730"] = "2 ano";
	    return $vet_month;
	}
	
	function dt_year_array()
	{
	    $parada = date("Y")+5;
	    while($parada >= 2008)
	    {
	        $returnArray[$parada] = $parada;
	        $parada--;
	    }
	    return $returnArray;
	}
	
	function shirt_functionary_array()
	{
	    $vet_month["P"] = "P";
	    $vet_month["M"] = "M";
	    $vet_month["G"] = "G";
	    $vet_month["GG"] = "GG";
	    return $vet_month;
	}
	/*------------------ FIM MANIPULACAO DE DATAS E HORAS --------------------------*/
	
	
	/*--------------- VALIDACAO DE CAMPOS DO BANCO DE DADOS ------------------------*/
	private function time_validade($hr)
	{
		$hr = explode (":", $hr);
		if(isset($hr[0]) && isset($hr[1]) && is_numeric($hr[0]) && is_numeric($hr[1]))
			return true;
		return false;
	}
	
	function time_db($hr)
	{
		if($this->time_validade($hr))
			return "'".$hr."'";
		return "NULL";
	}
	
	function date_db($data)
	{
	    if(strpos($data, "-") == 4)
	        $data = $this->db_date($data);
	    
		$data = explode("/", $data);
		if( isset($data[0]) && is_numeric($data[0]) && $data[0] > 0 && $data[0] < 32
				&& isset($data[1]) && is_numeric($data[1]) && $data[1] > 0 && $data[1] < 13
				&& isset($data[2]) && is_numeric($data[2])	&& $data[2] > 1900 && $data[2] < 2100
				&& checkdate($data[1],$data[0],$data[2]))
			return "'$data[2]-$data[1]-$data[0]'";
		return "NULL";
	}
	
	function date_time_db($data)
	{
		if($data != "")
		{
			$data_final = "";
			$data = explode(" ", $data);
			if(!isset($data[0]) || !isset($data[1]) )
				return "NULL"; //formato invalido
			$ano = explode("/", $data[0]);
			if(isset($ano[0]) && is_numeric($ano[0]) && isset($ano[1]) && is_numeric($ano[1]) && isset($ano[2]) && is_numeric($ano[2])	&& checkdate($ano[1],$ano[0],$ano[2]))
				$data_final = "$ano[2]-$ano[1]-$ano[0]";
			else
				return "NULL"; //formato valido porem data invalida
			if($data_final == "")
				return "NULL";
			$hora = explode(":", $data[1]);
			if(isset($hora[0]) && is_numeric($hora[0]) && $hora[0] >= 0 && $hora[0] < 24 && isset($hora[1]) && is_numeric($hora[1]) && $hora[1] >= 0 && $hora[1] < 60)
				return "'$data_final $data[1]'";
		}
		return "NULL";
	}
	
	function boolean_db($valor)
	{
		if($valor == "1" || $valor == "0")
			return $valor;
		return "NULL";
	}
	
	function float_db($numero)
	{
	    $numero = trim($numero);
		$numero = str_replace(".", "", $numero);
		$numero = str_replace(",", ".", $numero);
		if(is_numeric($numero))
			return $numero;
		return "NULL";
	}
	
	function float_zero_db($numero)
	{
		$numero = str_replace(".", "", $numero);
		$numero = str_replace(",", ".", $numero);
		if(is_numeric($numero))
			return $numero;
		return 0;
	}
	
	function int_db($numero)
	{
		if(is_numeric($numero))
			return $numero;
		return "NULL";
	}
	
	function int_zero_db($numero)
	{
		if(is_numeric($numero))
			return $numero;
		return 0;
	}
	
	function string_db($string)
	{
		if($string == "")
			return "NULL";
		else
		{
		    $string1 = str_replace('\"', '', $string);
			$string_final = str_replace("\'", "", $string1);
			$string_final = str_replace("'", "", $string_final);
			return "'".trim($string_final)."'";
		}
	}
	
	function string_upper_db($string)
	{
	    if($string == "")
	        return "NULL";
        else
        {
            $string1 = str_replace('\"', '', $string);
            $string_final = str_replace("\'", "", $string1);
            $string_final = str_replace("'", "", $string_final);
            return "'".$this->str_uppercase(trim($string_final))."'";
        }
	}
	
	function email_db($email)
	{
		if($email == "")
			return "NULL";
		if($this->email_validate($email) == true)
			return "'" . strtolower(addslashes($email)) . "'";
		else
			return false;
	}
	
	function cep_db($cep)
	{
		$dados = array(".", "-");
		$cep = str_replace($dados, "", $cep);
		if(is_numeric($cep) && $cep > 1000000)
			return $cep;
		return "NULL";
	}
	
	function phone_db($phone)
	{
		$dados = array("(", ")", "-");
		$phone = str_replace($dados, "", $phone);
		if(is_numeric($phone) && $phone > 1000000000)
			return $phone;
		return "NULL";
	}
	
	function cnpj_db($valor)
	{
		$dados = array(".", "/", "-");
		$cnpj = str_replace($dados, "", $valor);
		$inscricao = "";
		if(is_numeric($cnpj))
		{
			$inscricao = substr($cnpj, 0, 12);
			$codigo = array ("6","5","4","3","2","9","8","7","6","5","4","3","2");
			$soma = 0;
			for($i=0;$i<12;$i++)
				$soma += substr($inscricao, $i, 1) * $codigo[$i+1];
			$resto = $soma % 11;
			if($resto < 2)
				$resto = 0;
			else
				$resto = 11 - $resto;
			$inscricao = "$inscricao"."$resto";
			$soma = 0;
			for($i=0;$i<13;$i++)
				$soma += substr($inscricao, $i, 1) * $codigo[$i];
			$resto = $soma % 11;
			if($resto < 2)
				$resto = 0;
			else
				$resto = 11 - $resto;
			$inscricao = "$inscricao"."$resto";
		}
		if($inscricao == $cnpj && $cnpj != "")
			return $cnpj;
		return "NULL";
	}
	
	function cpf_db($valor)
	{
		$dados = array(".", "-");
		$cpf = str_replace($dados, "", $valor);
		$inscricao = "";
		if(is_numeric($cpf))
		{
			$inscricao = substr($cpf, 0, 9);
			$codigo = array ("11","10","9","8","7","6","5","4","3","2");
			$soma = 0;
			for($i=0;$i<9;$i++)
				$soma += substr($inscricao, $i, 1) * $codigo[$i+1];
			$resto = $soma % 11;
			if($resto < 2)
				$resto = 0;
			else
				$resto = 11 - $resto;
			$inscricao = "$inscricao"."$resto";
			$soma = 0;
			for($i=0;$i<10;$i++)
				$soma += substr($inscricao, $i, 1) * $codigo[$i];
			$resto = $soma % 11;
			if($resto < 2)
				$resto = 0;
			else
				$resto = 11 - $resto;
			$inscricao = "$inscricao"."$resto";
		}
		if($inscricao == $cpf && $cpf != "")
			return $cpf;
		return "NULL";
	}
	
	function pis_db($pis)
	{
		$pis = preg_replace('/[^0-9]+/', '', $pis);
		if(strlen($pis) <> 11)
			return "NULL";
		$digito = 0;
		for($i = 0, $x=3; $i<10; $i++, $x--)
		{
			$x = ($x < 2) ? 9 : $x;
			$digito += $pis[$i]*$x;
		}
		$calculo = (($digito%11) < 2) ? 0 : 11-($digito%11);
		//Se o valor da variavel cálculo for diferente do último digito, ele será inválido, senão verdadeiro
		if($calculo == $pis[10])
			return $pis;
		else
			return "NULL";
	}
	
	/*--------*/
	
	function db_time($hr)
	{
		$hr_ex = explode (":", $hr);
		$hr_return = ($hr_ex[0].":".$hr_ex[1]);
		if($hr_return == ":")
			$hr_return = "";
		return $hr_return;
	}
	
	function db_date($data)
	{
		if($data != "")
		{
			$data = explode("-", $data);
			if( isset($data[0]) && isset($data[1]) && isset($data[2]))
				return "$data[2]/$data[1]/$data[0]";
		}
		return;
	}
	
	function db_date_php($data)
	{
	    if(strstr($data,"-"))
	    {
	        $dt_ex = explode("-", $data);
	        return date("Y-m-d", mktime(0,0,0,$dt_ex[1], $dt_ex[2], $dt_ex[0]));
	    }
	    elseif(strstr($data,"/"))
	    {
	        $dt_ex = explode("/", $data);
	        return date("Y-m-d", mktime(0,0,0,$dt_ex[1], $dt_ex[0], $dt_ex[2]));
	    }
	}
	
	function db_date_mini($data, $is_year = true)
	{
		if($data != "")
		{
			$data = explode("-", $data);
			if(isset($data[0]) && isset($data[1]) && isset($data[2]))
			{
				$year = substr($data[0], -2);
				if($is_year)
				    return "$data[2]/$data[1]/$year";
                else
                    return "$data[2]/$data[1]";
			}
		}
		return;
	}
	
	function db_date_time($data)
	{
		if($data != "")
		{
			$data = explode(" ", $data);
			$ano = $this->db_date($data[0]);
			$hora = explode (".", $data[1]);
			$hora = explode (":", $hora[0]);
			return "$ano $hora[0]:$hora[1]";
		}
		return;
	}
	
	function db_date_timeoff($data)
	{
		if($data != "")
		{
			$data = explode(" ", $data);
			$ano = $this->db_date($data[0]);
			return "$ano";
		}
		return;
	}
	
	function db_date_timeoff_mini($data)
	{
		if($data != "")
		{
			$data = explode(" ", $data);
			$ano = $this->db_date($data[0]);
			$ano_explode = explode("/", $ano);
			$ano = substr($ano_explode[2], -2);
			return "$ano_explode[0]/$ano_explode[1]/$ano";
		}
		return;
	}
	
	function db_date_time_chat($data)
	{
	    if($data != "")
	    {
	        $data = explode(" ", $data);
	        $ano = $this->db_date($data[0]);
	        $ano_explode = explode("/", $ano);
	        $ano = substr($ano_explode[2], -2);
	        $hora = explode (".", $data[1]);
	        $hora = explode (":", $hora[0]);
	        return "$ano_explode[0]/$ano_explode[1]/$ano $hora[0]:$hora[1]";
	    }
	    return;
	}
	
	function href_phone($n_phone)
	{
	    ?><a href="tel:<?=$n_phone?>"><?=$n_phone?></a><?
	}
	
	function db_boolean($tipo, $valor)
	{
		if($tipo == 1)
		{
			if($valor == "1")
				return "Ativo";
			else
				return "Inativo";
		}
		elseif($tipo == 2)
		{
			if($valor == "1")
				return "Pessoa Jurídica";
			else
				return "Pessoa Física";
		}
		elseif($tipo == 3)
		{
			if($valor == "1")
				return "Masculino";
			else
				return "Feminino";
		}
		elseif($tipo == 4)
		{
			if($valor == "1")
				return "Sim";
			else
				return "Não";
		}
		elseif($tipo == 5)
		{
			if($valor == "1")
				return "Em Aberto";
			else
				return "Finalizado";
		}
		elseif($tipo == 6)
		{
			if($valor == "1")
				return "Cancelamento";
			else
				return "Devolução";
		}
		elseif($tipo == 7)
		{
			if($valor == "1")
				return "Mandaguari";
			else
				return "Terceiros";
		}
		elseif($tipo == 8)
		{
			if($valor == "1")
				return "Em Aberto";
			else
				return "Liquidado";
		}
		elseif($tipo == 9)
		{
			if($valor == "1")
				return "Dias";
			else
				return "Velocímetro rodado";
		}
		elseif($tipo == 10)
		{
			if($valor == "1")
				return "Aprovado";
			else
				return "Reprovado";
		}
		elseif($tipo == 11)
		{
			if($valor == "1")
				return "Estoque";
			else
				return "Descarte";
		}
		elseif($tipo == 12)
		{
			if($valor == "1")
				return "Lançado";
			else
				return "Vinculado";
		}
		elseif($tipo == 13)
		{
			if($valor == "1")
				return "Em Aberto";
			else
				return "Solicitado";
		}
		elseif($tipo == 14)
		{
			if($valor == "1")
				return "Em Vigência";
			else
				return "Encerrado";
		}
		elseif($tipo == 15)
		{
			if($valor == "1")
				return "<font color='#B8860B'>Lançado</font>";
			else
				return "<font color='#228B22'>Conciliado</font>";
		}
		elseif($tipo == 16)
		{
			if($valor == "1")
				return "O";
			else
				return "I";
		}
		elseif($tipo == 17)
		{
			if($valor == "1")
				return "Escritório";
			else
				return "Fazenda";
		}
		elseif($tipo == 18)
		{
			if($valor == "1")
				return "NF despesa";
			else
				return "NF peças";
		}
		elseif($tipo == 19)
		{
			if($valor == "1")
				return "Administrador";
			else
				return "Somente leitura";
		}
		elseif($tipo == 20)
		{
			return "VAZIIIIO";
		}
		elseif($tipo == 21)
		{
		    if($valor == "1")
		        return "Auto";
	        else
	            return "Manual";
		}
		elseif($tipo == 22)
		{
		    if($valor == "1")
		        return "TED";
	        else
	            return "Cheque";
		}
		elseif($tipo == 23)
		{
		    if($valor == "1")
		        return "CIF";
	        else
	            return "FOB";
		}
		elseif($tipo == 24)
		{
		    if($valor == "1")
		        return "Produção";
	        else
	            return "R$";
		}
		elseif($tipo == 25)
		{
		    if($valor == "1")
		        return "<font color='#B8860B'>Válido</font>";
	        else
	            return "<font color='#FF0000'>Inválido</font>";
		}
	}
	
	function db_money($valor, $decimal = 2)
	{
		$number_return = number_format($valor, $decimal, ",", ".");
		if($number_return == "-0,00")
		    $number_return = "0,00";
		return $number_return;
	}
	
	function db_cep($cep)
	{
		if($cep)
		{
			if($cep < 10000000)
				$cep = "0$cep";
			return substr($cep, 0, 2).".".substr($cep, 2, 3)."-".substr($cep, 5, 3);
		}
	}
	
	function db_phone($phone)
	{
		if($phone)
		{
			$tam = strlen(preg_replace("/[^0-9]/", "", $phone));
			if ($tam == 11)
				return "(".substr($phone,0,2).")".substr($phone,2,5)."-".substr($phone,7,11);
			elseif ($tam == 10)
				return "(".substr($phone,0,2).")".substr($phone,2,4)."-".substr($phone,6,10);
		}
	}
	
	function db_cpf($cpf)
	{
		$temp = "$cpf";
		for($i=0; strlen($temp) < 11; $i++)
			$temp = "0"."$temp";
		$temp = substr($temp, 0, 3).".".substr($temp, 3, 3).".".substr($temp, 6, 3)."-".substr($temp, 9, 2);
		return $temp;
	}
	
	function db_pis($pis)
	{
		$temp = "$pis";
		for($i=0; strlen($temp) < 11; $i++)
			$temp = "0"."$temp";
		$temp = substr($temp, 0, -10).".".substr($temp, 1, -7).".".substr($temp, 4, -4).".".substr($temp, 7, -1)."-".substr($temp, -1);
		return $temp;
	}
	
	function db_cnpj($cnpj)
	{
		$temp = "$cnpj";
		for($i=0; strlen($temp) < 14; $i++)
			$temp = "0"."$temp";
		$temp = substr($temp, 0, 2).".".substr($temp, 2, 3).".".substr($temp, 5, 3)."/".substr($temp, 8, 4)."-".substr($temp, 12, 2);
		return $temp;
	}
	/*------------- FIM VALIDACAO DE CAMPOS DO BANCO DE DADOS ------------------------*/
	
	
	/*-------------------- PRINT DOS CAMPOS DO BANCO DE DADOS ------------------------*/
	function db_type_phone($type)
	{
		if($type == 1)
			return "Celular";
		elseif($type == 2)
			return "Comercial";
		elseif($type == 3)
			return "Residencial";
		elseif($type == 4)
			return "Parentes";
		elseif($type == 5)
			return "Celular(whatsapp)";
	}
	
	function db_status_word($status)
	{
		if($status == 1)
			return "Não Lido";
		elseif($status == 2)
			return "Lido";
		elseif($status == 3)
			return "Concluído";
	}
	
	function db_status_agenda_farming($status)
	{
	    if($status == 1)
	        return "Ativo";
        elseif($status == 2)
	        return "Inativo";
        elseif($status == 3)
	        return "Em execução";
	}
	
	function db_status_farming($status)
	{
	    if($status == 1)
	        return "Planejada";
        elseif($status == 2)
	        return "Abortada";
        elseif($status == 3)
	        return "Plantada";
        elseif($status == 4)
	        return "Colhida";
        elseif($status == 5)
	        return "Finalizada";
	}
	
	function db_type_truck($type)
	{
		if($type == 1)
			return "Truck";
		elseif($type == 2)
			return "Bitrem";
		elseif($type == 3)
			return "Carreta";
		elseif($type == 4)
			return "Rodotren";
		elseif($type == 5)
			return "Toco";
		elseif($type == 6)
			return "3/4";
		elseif($type == 7)
			return "Bitruck";
	}
	
	function db_status_oc($status)
	{
	    if($status == 1)
	        return "Iniciada";
		elseif($status == 2)
		    return "Cancelada";
		elseif($status == 3)
		    return "Finalizada";
	}
	
	function db_status_oc_transport($status)
	{
		if($status == 1)
			return "Iniciada";
		elseif($status == 2)
			return "Cancelada";
		elseif($status == 3)
			return "Impressa";
		elseif($status == 4)
			return "Romaneio";
		elseif($status == 5)
			return "N.F. emitida";
		elseif($status == 6)
			return "Finalizada";
	}
	
	function db_status_oc_transport_fit($status)
	{
	    if($status == 1)
	        return "Solicitado";
        elseif($status == 2)
	        return "Reprovado";
        elseif($status == 3)
	        return "Aprovado";
	}
	
	function db_status_document($status)
	{
		if($status == 1)
			return "Regular";
		elseif($status == 2)
			return "Vencendo";
		elseif($status == 3)
			return "Vencido";
		elseif($status == 4)
			return "Arquivado";
	}
	
	function db_status_contract($status)
	{
		if($status == 1)
			return "Em contratação";
		elseif($status == 2)
			return "Contratado";
		elseif($status == 3)
			return "Não contratado";
	}
	
	function db_status_buy($status)
	{
		if($status == 0)
			return "Aguardando liberação";
		if($status == 1)
			return "Solicitado";
		elseif($status == 2)
			return "Compra redirecionada";
		elseif($status == 3)
			return "Especificar melhor";
		elseif($status == 4)
			return "Reprovado";
		elseif($status == 5)
			return "Em cotação";
		elseif($status == 6)
			return "Cotação finalizada";
		elseif($status == 7)
			return "Aprovado p/ comprar";
		elseif($status == 8)
			return "Comprado";
		elseif($status == 9)
			return "Em recebimento";
		elseif($status == 10)
			return "Recebido";
	}
	
	function db_status_buy_request($status)
	{
		if($status == 1)
			return "Solicitado";
		elseif($status == 2)
			return "Cancelado";
		elseif($status == 3)
			return "Enviado";
		elseif($status == 4)
			return "Recebido";
	}
	
	function db_status_quote($status)
	{
		if($status == 0)
			return "Em Aberto";
		elseif($status == 1)
			return "Aprovada";
		elseif($status == 2)
			return "Reprovada";
	}
	
	function db_original_financial($status)
	{
		if($status == 1)
			return "Contas a pagar (direto)";
		elseif($status == 2)
			return "Contas a pagar (RE)";
		elseif($status == 3)
			return "Contas a receber";
		elseif($status == 4)
			return "Transações bancárias";
	}
	
	function db_status_financial($status)
	{
		if($status == 1)
			return "Em análise";
		elseif($status == 2)
			return "Especificar melhor";
		elseif($status == 3)
			return "Reprovado";
		elseif($status == 4)
			return "Aprovado";
	}
	
	function db_status_financial_box($status)
	{
	    if($status == 1)
	        return "Aguardando pgto";
        elseif($status == 2)
	        return "Em aberto";
        elseif($status == 3)
	        return "Finalizado";
	}
	
	function db_type_classification($status)
	{
		if($status == 1)
			return "Histórico";
		elseif($status == 2)
			return "Planejamento";
		elseif($status == 3)
			return "Outros";
	}
	
	function db_status_parcel($status)
	{
		if($status == 1)
			return "<font color='#B8860B'>Em aberto</font>";
		elseif($status == 2)
			return "<font color='#FF0000'>Vencido</font>";
		elseif($status == 3)
			return "<font color='#0066FF'>Não compensado</font>";
		elseif($status == 4)
			return "<font color='#228B22'>Finalizado</font>";
	}
	
	function db_financier_parcel($status)
	{
		if($status == 1)
			return "Não contábil";
		elseif($status == 2)
			return "Lucas";
		elseif($status == 3)
			return "Marinete";
		elseif($status == 4)
			return "Johannes";
		elseif($status == 5)
			return "Giovanna";
		elseif($status == 6)
			return "Michelle";
	}
	
	function db_status_product($status)
	{
		if($status == 1)
			return "Ag. aprovação";
		elseif($status == 2)
			return "Inativo";
		elseif($status == 3)
			return "Devolvido";
		elseif($status == 4)
			return "Ativo";
	}
	
	function db_status_product_stockupdate($status)
	{
	    if($status == 1)
	        return "Ag. aprovação";
        elseif($status == 2)
	        return "Reprovado";
        elseif($status == 3)
	        return "Aprovado";
	}
	
	function db_status_review($status)
	{
	    if($status == 1)
	        return "Ag. aprovação";
        elseif($status == 2)
	        return "Inativo";
        elseif($status == 3)
	        return "Devolvido";
        elseif($status == 4)
	        return "Ativo";
	}
	
	function db_status_machine_main($status)
	{
	    if($status == 1)
	        return "<font color='#000000'>Ag. aprovação</font>";
        elseif($status == 2)
	        return "<font color='#000000'>Devolvido</font>";
	    elseif($status == 3)
	        return "<font color='#1E90FF'>No prazo</font>";
        elseif($status == 4)
	        return "<font color='#FF9933'>Vencendo</font>";
        elseif($status == 5)
	        return "<font color='#FF0000'>Vencido</font>";
        elseif($status == 6)
	        return "<font color='#009933'>Finalizado</font>";
	}
	
	function db_type_cons_predial($type)
	{
		if($type == 1)
			return "Alvenaria";
		elseif($type == 2)
			return "Madeira";
		elseif($type == 3)
			return "Placa";
		elseif($type == 4)
			return "Sem construção";
	}
	
	function db_type_contract($type)
	{
		if($type == 1)
			return "Experiência";
		elseif($type == 2)
			return "Por safra";
		elseif($type == 3)
			return "Permanente";
		elseif($type == 4)
			return "Avulso";
	}
	
	function db_type_return_buy($type)
	{
	    if($type == 1)
	        return "Dev. solicitante";
        elseif($type == 2)
	        return "Dev. comprador";
        elseif($type == 3)
	        return "Analise";
        elseif($type == 4)
	        return "Troca comprador";
	}
	
	function db_type_return_product($type)
	{
	    if($type == 1)
	        return "Dev. solicitante";
        elseif($type == 2)
	        return "Dev. aprovador";
        elseif($type == 3)
	        return "Dev. organizador de nomes";
	}
	
	function db_status_security($st)
	{
		if($st == 1)
			return "Em vigência";
		elseif($st == 2)
			return "Vencido";
		elseif($st == 3)
			return "Finalizado";
	}
	
	function db_status_solicitation_product($status)
	{
	    if($status == 1)
			return "Em aberto";
		elseif($status == 2)
			return "Prazo vencido";
		elseif($status == 3)
			return "Entregue";
		elseif($status == 4)
			return "Devolvido";
	}
	
	function db_counter_machine($status)
	{
		if($status == 1)
			return "Ø";
		elseif($status == 2)
			return "km";
		elseif($status == 3)
			return "H";
	}
	
	function db_status_machine($status)
	{
	    if($status == 1)
	        return "Pré-cadastro";
        elseif($status == 2)
	        return "Inativo";
        elseif($status == 3)
	        return "Ativo";
	}
	
	function db_status_functionary($status)
	{
		if($status == 1)
			return "Cadastrado";
		elseif($status == 2)
			return "Inativo";
		elseif($status == 3)
			return "Registrado";
		elseif($status == 4)
			return "Avulso";
	}
	
	function db_status_checkprint($status)
	{
		if($status == 1)
			return "Não impresso";
		elseif($status == 2)
			return "Impresso";
		elseif($status == 3)
			return "Impresso manualmente";
		elseif($status == 4)
			return "Cancelado";
	}
	
	function db_status_custodia($status)
	{
		if($status == 1)
			return "Recepcionado";
		elseif($status == 2)
			return "Cancelado";
		elseif($status == 3)
			return "Depositado";
		elseif($status == 4)
			return "Custodiado";
		elseif($status == 5)
			return "Devolvido";
		elseif($status == 6)
			return "Compensado";
		elseif($status == 7)
			return "Descontado";
	}
	
	function db_status_control($status)
	{
		if($status == 1)
		    return "Solicitada";
	    if($status == 2)
	        return "Ag. aprovação";
		elseif($status == 3)
			return "Em análise";
		elseif($status == 4)
			return "Cancelada";
		elseif($status == 5)
			return "Aprovada";
		elseif($status == 6)
			return "Devolvida";
		elseif($status == 7)
			return "Em execução";
		elseif($status == 8)
			return "Finalizada";
	}
	
	function db_status_os($status)
	{
		if($status == 1)
			return "Solicitada";
		elseif($status == 2)
			return "OS cancelada";
		elseif($status == 3)
			return "OS impressa";
		elseif($status == 4)
			return "OS completada";
		elseif($status == 5)
			return "Em cotação";
		elseif($status == 6)
			return "Cotação finalizada";
		elseif($status == 7)
			return "Devolvido p/ solicitante";
		elseif($status == 8)
			return "Devolvido p/ cotador";
		elseif($status == 9)
			return "Aguardando NF";
		elseif($status == 10)
			return "Finalizado";
	}
	
	function db_status_labor($status)
	{
		if($status == 1)
			return "Lançado";
		elseif($status == 2)
			return "Devolvido para ajustes";
		elseif($status == 3)
			return "Finalizado";
	}
	
	function db_type_phstock($status)
	{
		if($status == 1)
			return "Entrada principal";
		elseif($status == 2)
			return "Movimentação";
		elseif($status == 3)
			return "Saída";
		elseif($status == 4)
			return "Saída (descarte/bonificado)";
		elseif($status == 5)
			return "Ajuste de estoque";
	}
	
	function db_status_phstock($status)
	{
		if($status == 0)
			return "Aguardando liberação";
		elseif($status == 1)
		    return "Solicitado";
		elseif($status == 2)
			return "Cancelado";
		elseif($status == 3)
			return "Enviado";
		elseif($status == 4)
			return "Finalizado";
	}
	
	function db_status_farming_event($status)
	{
		if($status == 1)
			return "Não lido";
		elseif($status == 2)
			return "Cancelado";
		elseif($status == 3)
			return "Concluído";
	}
	
	function db_status_calleddp($status)
	{
	    if($status == 1)
        return "Solicitado";
	        elseif($status == 2)
        return "Cancelado";
	        elseif($status == 3)
        return "Finalizado";
	}
	
	function db_status_collection($status)
	{
	    if($status == 1)
	        return "Solicitado";
        elseif($status == 2)
	        return "Cancelado";
        elseif($status == 3)
	        return "Aprovado";
	}
	
	function db_civil_functionary($type)
	{
		if($type == "S")
			return "Solteiro(a)";
		elseif($type == "C")
			return "Casado(a)";
		elseif($type == "V")
			return "Viúvo(a)";
		elseif($type == "D")
			return "Divorciado(a)";
		elseif($type == "U")
			return "União estável";
	}
	
	function db_term_client($term)
	{
	    if($term == 0)
	        return "A vista";
        else
	        return "$term dia(s)";
	}
	
	function db_scholarity_functionary($type)
	{
	    if($type == 1)
	        return "Analfabeto";
	    elseif($type == 5)
	        return "Ensino fundamental";
        elseif($type == 7)
	        return "Ensino medio";
        elseif($type == 9)
	        return "Ensino superior";
	}
	
	function db_division_function($division_function)
	{
	    if($division_function == 1)
	        return "Administrativo";
        elseif($division_function == 2)
	        return "Operacional";
        elseif($division_function == 3)
	        return "Produção";
	}
	
	function db_type_parent_functionary_dependent($type)
	{
	    if($type == 1)
	        return "conjuge";
        elseif($type == 2)
	        return "Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 anos";
        elseif($type == 3)
	        return "Filho(a) ate 21 anos";
        elseif($type == 4)
	        return "Filho(a) universitaria ate 24 anos";
        elseif($type == 5)
	        return "Filho(a) em qualquer idade, quando incapacitado fisico ou mental para o trabalho";
        elseif($type == 6)
	        return "Irmao(a), neto(a) do qual detenha guarda ate 21 anos";
        elseif($type == 7)
	        return "Irmao(a), neto(a) do qual detenha guarda ate 24 anos";
        elseif($type == 8)
	        return "Irmao(a), neto(a) em qualquer idade, quando incapacitado fisico ou mental para o trabalho";
        elseif($type == 9)
	        return "Pais, avos ou bisavos";
        elseif($type == 10)
	        return "Menor pobre ate 21 anos";
        elseif($type == 11)
	        return "A pessoa incapaz, da qual seja tutor ou curador";
        elseif($type == 12)
	        return "Ex-conjuge que receba pensao de alimentos";
        elseif($type == 13)
	        return "Agregado/outros";
	}
	
	function db_type_calendar($status)
	{
	    if($status == 1)
	        return "Único";
        elseif($status == 2)
	        return "Mensal";
        elseif($status == 3)
	        return "Anual";
	}
	
	function db_origins_financial($origins)
	{
	    if(str_contains($origins, '/?'))
	        return "<a target='_blank' href='".$origins."'>$origins</a>";
	    else
	        return $origins;
	}
	
	function db_type_pix_people_bank($status)
	{
	    if($status == 1)
	        return "CPF";
        elseif($status == 2)
	        return "CNPJ";
        elseif($status == 3)
	        return "E-mail";
        elseif($status == 4)
	        return "Celular";
	}
	
	function db_type_pix_people_bank_array()
	{
	    $vet_fp["1"] = "CPF";
	    $vet_fp["2"] = "CNPJ";
	    $vet_fp["3"] = "E-mail";
	    $vet_fp["4"] = "Celular";
	    return $vet_fp;
	}
	
	function db_dregeral_array()
	{
	    $vet_month["1"] = "Custos";
	    $vet_month["2"] = "Realizado";
	    $vet_month["3"] = "Deduções";	    
	    $vet_month["4"] = "Despesas";
	    $vet_month["5"] = "Despesas financeiras";
	    $vet_month["6"] = "Impostos e taxas";
	    $vet_month["7"] = "Investimentos";
	    $vet_month["8"] = "Entrada não operacional";
	    $vet_month["9"] = "Não se aplica";
	    return $vet_month;
	}
	
	function db_type_dregeral($status)
	{
	    if($status == 1)
	        return "Custos";
        elseif($status == 2)
	        return "Realizado";
        elseif($status == 3)
	        return "Deduções";
        elseif($status == 4)
	        return "Despesas";
        elseif($status == 5)
	        return "Despesas financeiras";
        elseif($status == 6)
	        return "Impostos e taxas";
        elseif($status == 7)
            return "Investimentos";
        elseif($status == 8)
	        return "Entrada não operacional";
        elseif($status == 9)
	        return "Não se aplica";
	}
	
	function db_functionary_dependent_array()
	{
	    $vet_fp["1"] = "Conjuge";
	    $vet_fp["2"] = "Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 anos";
	    $vet_fp["3"] = "Filho(a) ate 21 anos";
	    $vet_fp["4"] = "Filho(a) universitaria ate 24 anos";
	    $vet_fp["5"] = "Filho(a) em qualquer idade, quando incapacitado fisico ou mental para o trabalho";
	    $vet_fp["6"] = "Irmao(a), neto(a) do qual detenha guarda ate 21 anos";
	    $vet_fp["7"] = "Irmao(a), neto(a) do qual detenha guarda ate 24 anos";
	    $vet_fp["8"] = "Irmao(a), neto(a) em qualquer idade, quando incapacitado fisico ou mental para o trabalho";
	    $vet_fp["9"] = "Pais, avos ou bisavos";
	    $vet_fp["10"] = "Menor pobre ate 21 anos";
	    $vet_fp["11"] = "A pessoa incapaz, da qual seja tutor ou curador";
	    $vet_fp["12"] = "Ex-conjuge que receba pensao de alimentos";
	    $vet_fp["13"] = "Agregado/outros";
	    return $vet_fp;
	}
	
	function db_dsr_array()
	{
	    $vet_dsr["0"] = "Domingo";
	    $vet_dsr["1"] = "Segunda";
	    $vet_dsr["2"] = "Terça";
	    $vet_dsr["3"] = "Quarta";
	    $vet_dsr["4"] = "Quinta";
	    $vet_dsr["5"] = "Sexta";
	    $vet_dsr["6"] = "Sábado";
	    return $vet_dsr;
	}
	
	function pointing_evaluation_fivestars_array()
	{
	    $vet_type["1"] = "Péssima";
	    $vet_type["2"] = "Ruim";
	    $vet_type["3"] = "Mediana";
	    $vet_type["4"] = "Boa";
	    $vet_type["5"] = "Excelente";
	    return $vet_type;
	}
	
	function db_pointing_evaluation_fivestars($status)
	{
        if($status == 1)
            return "Péssima";
        elseif($status == 2)
            return "Ruim";
        elseif($status == 3)
            return "Mediana";
        elseif($status == 4)
            return "Boa";
        elseif($status == 5)
            return "Excelente";
	}
	
	function db_input_dininghall($input)
	{
	    if($input == 1)
	        return "Colaborador";
        elseif($input == 2)
	        return "Prestadores";
        elseif($input == 3)
	        return "Convidados";
	}
	/*------------------ FIM PRINT DOS CAMPOS DO BANCO DE DADOS ------------------------*/
	
	
	/*--------------------------- SQL GENERATION SEARCHS -------------------------------*/
	function sql_integer($vet_sql, $field)
	{
		if($vet_sql != "")
			return " AND $field = ".$this->int_db($vet_sql);
	}
	
	function sql_float($vet_sql, $field)
	{
		if($vet_sql != "")
			return " AND $field = ".$this->float_db($vet_sql);
	}
	
	function sql_bool($vet_sql, $field)
	{
		if($vet_sql != "")
			return " AND $field = ".$this->boolean_db($vet_sql);
	}
	
	function sql_cpf($vet_sql, $field)
	{
		if($vet_sql != "")
			return " AND $field = ".$this->cpf_db($vet_sql);
	}
	
	function sql_cnpj($vet_sql, $field)
	{
		if($vet_sql != "")
			return " AND $field = ".$this->cnpj_db($vet_sql);
	}
	
	function sql_string($vet_sql, $field)
	{
		if($vet_sql != "")
			return " AND $field LIKE '%".addslashes($vet_sql)."%'";
	}
	
	function sql_string_duo($vet_sql, $field1, $field2)
	{
	    if($vet_sql != "")
	        return " AND ($field1 LIKE '%".addslashes($vet_sql)."%' or $field2 LIKE '%".addslashes($vet_sql)."%')";
	}
	
	function sql_pis($vet_sql, $field)
	{
		if($vet_sql != "")
			return " AND $field = ".$this->pis_db($vet_sql);
	}
	
	function sql_or($field, $vet_sql)
	{
	    if($vet_sql)
	    {
	        if(count($vet_sql) == 1)
	            return " and $field = $vet_sql[0]";
            else
            {
                $sql_return .= " and (";
                foreach ($vet_sql as $st)
                {
                    if($st)
                        $sql_return .= " $field = ".$st." or";
                }
                $sql_return .= ")";
                return str_replace("or)",")",$sql_return);
            }
	    }
	    else
	        return "";
	}
	
	function sql_date($dt_ini, $dt_end, $dt_field, $time = null)
	{
	    if(strpos($dt_ini, "-") == 4)
	        $dt_ini = $this->db_date($dt_ini);
        if(strpos($dt_end, "-") == 4)
            $dt_end = $this->db_date($dt_end);

		if($time)
		{
			if($dt_ini != "")
				$dt_ini_db = $this->date_time_db($dt_ini." 00:00");
			if($dt_end != "")
				$dt_end_db = $this->date_time_db($dt_end." 23:59:59");
		}
		else
		{
			if($dt_ini != "")
				$dt_ini_db = $this->date_db($dt_ini);
			if($dt_end != "")
				$dt_end_db = $this->date_db($dt_end);
		}

		if($dt_ini_db != "" && $dt_end_db !="")
			$string_sql .= " AND $dt_field BETWEEN $dt_ini_db AND $dt_end_db";
		else
			if($dt_ini_db != "")
				$string_sql .= " AND $dt_field >= $dt_ini_db";
		else
			if($dt_end_db != "")
				$string_sql .= " AND $dt_field <= $dt_end_db";
		return $string_sql;
	}
	/*------------------------- FIM SQL GENERATION SEARCHS -------------------------------*/


	/*-------------------------- FUNCOES EM GERAL ------------------------------------*/
	function email_validate($email)
	{
		$er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
		if (preg_match($er, $email))
			return true;
		return false;
	}

	function porcent($valor, $porcentagem)
	{
		$porcent = ($valor * $porcentagem) / 100 ;
		return $porcent;
	}

	function is_pair($valor)
	{
	    if($valor % 2 == 0)
	        return true;
        return false;
	}

	function array_to_str($vet, $delimitator)
	{
		foreach ($vet as $id)
		{
			$string .= $id.$delimitator;
		}
		return $string;
	}

	function str_to_array($str, $delimitator)
	{
	    return explode($delimitator, $str);
	}

	function str_random($tamanho, $numeros = false, $caracter = false, $maiusculas = false, $simbolos = false)
	{
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$retorno = '';
		$caracteres = '';
		if($caracter)
		    $caracteres .= $lmin;
	    if($maiusculas)
	        $caracteres .= $lmai;
		if($numeros)
		    $caracteres .= $num;
		if($simbolos)
		    $caracteres .= $simb;

		$len = strlen($caracteres);
		for ($n = 1; $n <= $tamanho; $n++)
		{
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}

	function str_password($password)
	{
	    if(strlen($password)>=6)
	        return true;
	    return false;
	}

	function str_encryption($senha)
	{
		 $cod = md5($senha);
		 return $cod;
	}

	function str_uppercase($string)
	{
	    $upper = mb_strtoupper($string);
		return $upper;
	}

	function str_partition($str, $length, $etc = 1)
	{
	    session_start();
	    if($_SESSION["xls_sets"] == 1)
	        return $str;
        else
        {
            // matriz de entrada
            $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç');
            // matriz de saída
            $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C');
            // devolver a string
            $str_new = str_replace($what, $by, $str);
            $strlen_ori = strlen($str);
            $str_new = substr($str_new, 0, $length);
            $strlen_new = strlen($str_new);
            if($strlen_ori > $strlen_new && $etc == 1)
                $str_new .= "...";
            $return = "<div style='cursor: pointer' title='$str'>$str_new</div>";
            return $return;
        }
	}

	function str_remove_specialc($string)
	{
	    // matriz de entrada
	    $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	    // matriz de saída
	    $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C',' ','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	    // devolver a string
	    return str_replace($what, $by, $string);
	}

	function str_extensive($valor = 0, $maiusculas = false)
	{
		$singular = array("centavo", "real", "mil", "milhao", "bilhao", "trilhao", "quatrilhao");
		$plural = array("centavos", "reais", "mil", "milhoes", "bilhoes", "trilhoes", "quatrilhoes");
		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
		$z = 0;
		$rt = "";
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++)
		{
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
			$ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
			($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
		if(!$maiusculas)
			return($rt ? $rt : "zero");
		else
		{
		    if ($rt) $rt=str_replace(" E "," e ",ucwords($rt));
				return (($rt) ? ($rt) : "Zero");
		}
	}

	function str_complement_zeros($qt_zeros, $string)
	{
		$zeros_complement = "";
		$new_string_numbers = preg_replace("/[^0-9]/", "", $string); //retira todos os caracteres e deixa somente numeros;
		$condition_stop = $qt_zeros - strlen($new_string_numbers);

		for($i=1; $i <= $condition_stop; $i++)
			$zeros_complement .= 0; //complementa com zeros para fechar os caracteres.

		return $zeros_complement.$new_string_numbers;
	}

	function str_complement_space($qt_space, $string)
	{
		$space_complement = "";
		$new_string = substr($string, 0, $qt_space);
		$condition_stop = $qt_space - strlen($new_string);

		for($i=1; $i <= $condition_stop; $i++)
			$space_complement .= " "; //complementa com zeros para fechar os caracteres.

		return $new_string.$space_complement;
	}

	function str_extensive_months($months)
	{
		switch ($months)
		{
		    case "01":
		        return "Janeiro";
		        break;
		    case "02":
		        return "Fevereiro";
		        break;
		    case "03":
		        return "Março";
		        break;
		    case "04":
		        return "Abril";
		        break;
		    case "05":
		        return "Maio";
		        break;
		    case "06":
		        return "Junho";
		        break;
		    case "07":
		        return "Julho";
		        break;
		    case "08":
		        return "Agosto";
		        break;
		    case "09":
		        return "Setembro";
		        break;
		    case "10":
		        return "Outubro";
		        break;
		    case "11":
		        return "Novembro";
		        break;
		    case "12":
		        return "Dezembro";
		        break;
		}
	}

	function str_extensive_months_mini($months)
	{
		switch ($months)
		{
		    case "01":
		        return "Jan";
		        break;
		    case "02":
		        return "Fev";
		        break;
		    case "03":
		        return "Mar";
		        break;
		    case "04":
		        return "Abr";
		        break;
		    case "05":
		        return "Mai";
		        break;
		    case "06":
		        return "Jun";
		        break;
		    case "07":
		        return "Jul";
		        break;
		    case "08":
		        return "Ago";
		        break;
		    case "09":
		        return "Set";
		        break;
		    case "10":
		        return "Out";
		        break;
		    case "11":
		        return "Nov";
		        break;
		    case "12":
		        return "Dez";
		        break;
		}
	}

	function number_array($ini, $end)
	{
	    for($i=$ini; $i<=$end; $i++)
	    {
	        $returnArray[$i] = $i;
	    }
	    return $returnArray;
	}

	function qrcodereader_link_format($url)
	{
	    return str_replace("ç", ";", str_replace(";", "/", str_replace("Ç", ":", str_replace(":", "?", $url))));

	}

	public function utf8_decoding($field)
	{
	    session_start();
	    if($_SESSION["xls_sets"] == 1)
	    {
	        ?><?=utf8_decode($field)?><?
        }
        else
        {
            ?><?=$field?><?
        }
	}

	function is_extension_image($extension)
	{
		$imageExts = array("jpeg", "jpg", "png");
		if(in_array($extension, $imageExts))
		    return true;
	    return false;
	}

	function is_photos_mini($controller_photo_all)
	{
	    switch ($controller_photo_all)
	    {
	        case "bank":
	            return true;
	            break;
	        case "buy":
	            return true;
	            break;
	        case "checkprint":
	            return true;
	            break;
	        case "client":
	            return true;
	            break;
	        case "culture":
	            return true;
	            break;
	        case "driver":
	            return true;
	            break;
	        case "epi_test":
	            return true;
	            break;
	        case "farm":
	            return true;
	            break;
	        case "farming_event":
	            return true;
	            break;
	        case "financial_box":
	            return true;
	            break;
	        case "function":
	            return true;
	            break;
	        case "functionary_evaluation":
	            return true;
	            break;
	        case "functionary_event":
	            return true;
	            break;
	        case "functionary_exam":
	            return true;
	            break;
	        case "furnisher":
	            return true;
	            break;
	        case "gleba":
	            return true;
	            break;
	        case "labor":
	            return true;
	            break;
	        case "machine":
	            return true;
	            break;
	        case "machine_main":
	            return true;
	            break;
	        case "os":
	            return true;
	            break;
	        case "pc":
	            return true;
	            break;
	        case "point":
	            return true;
	            break;
	        case "predial":
	            return true;
	            break;
	        case "printer":
	            return true;
	            break;
	        case "product":
	            return true;
	            break;
	        case "product_phstock":
	            return true;
	            break;
	        case "security":
	            return true;
	            break;
	        case "solicitation":
	            return true;
	            break;
	        case "supply":
	            return true;
	            break;
	    }
	}
	/*------------------------ FIM FUNCOES EM GERAL ------------------------------------*/


	/*------------------------ GERANDO OS QR-CODE ------------------------------------*/
	function qrcode_generation_account($id_account)
	{
		?><a target="_blank" href="<?=URL_QRCODE?>/index/?id_account=<?=$id_account?>">
	    	<img src='https://chart.googleapis.com/chart?cht=qr&chl=<?=IP_SERVER?><?=URL_QRCODE?>/index/?id_account=<?=$id_account?>&chs=128x128&choe=UTF-8&chld=L|2' rel='nofollow'>
	    </a><?
	}

	function qrcode_generation_buy($id_buy)
	{
		$url_qrcode = "/buy/qrcoderedirect/?id_buy=$id_buy";
		?><a target="_blank" href="/index/qrcodeprint/?title_qrcode=<?=$id_buy?>&url_qrcode=<?=urlencode($url_qrcode)?>">
			<img  src='https://chart.googleapis.com/chart?cht=qr&chl=<?=IP_SERVER?><?=urlencode($url_qrcode)?>&chs=128x128&choe=UTF-8&chld=L|2'>
		</a><?
	}

	function qrcode_generation_pc($id_pc)
	{
	    $url_qrcode = "/pc/qrview/?id_pc=$id_pc";
	    ?><a target="_blank" href="/index/qrcodeprint/?title_qrcode=<?=$id_pc?>&url_qrcode=<?=urlencode($url_qrcode)?>">
			<img  src='https://chart.googleapis.com/chart?cht=qr&chl=<?=IP_SERVER?><?=urlencode($url_qrcode)?>&chs=128x128&choe=UTF-8&chld=L|2'>
		</a><?
	}

	function qrcode_generation_printer($id_printer)
	{
	    $url_qrcode = "/printer/qrview/?id_printer=$id_printer";
	    ?><a target="_blank" href="/index/qrcodeprint/?title_qrcode=<?=$id_printer?>&url_qrcode=<?=urlencode($url_qrcode)?>">
			<img  src='https://chart.googleapis.com/chart?cht=qr&chl=<?=IP_SERVER?><?=urlencode($url_qrcode)?>&chs=128x128&choe=UTF-8&chld=L|2'>
		</a><?
	}

	function qrcode_generation_cabinet($op1_cabinet, $op2_cabinet, $op3_cabinet)
	{
	    $url_qrcode = "/index/setcabinet/?op1_cabinet=$op1_cabinet&op2_cabinet=$op2_cabinet&op3_cabinet=$op3_cabinet";
	    ?><a target="_blank" href="/index/qrcodeprint/?title_qrcode=<?=$op1_cabinet?>.<?=$op2_cabinet?>.<?=$op3_cabinet?>&url_qrcode=<?=urlencode($url_qrcode)?>">
			<img  src='https://chart.googleapis.com/chart?cht=qr&chl=<?=IP_SERVER?><?=urlencode($url_qrcode)?>&chs=128x128&choe=UTF-8&chld=L|2'>
		</a><?
	}
	/*------------------------ FIM QR-CODE ------------------------------------*/
}
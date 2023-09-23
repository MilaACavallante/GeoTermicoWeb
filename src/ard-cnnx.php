<?php
require_once '../vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');
$html = [];

if(isset($_GET['ip']) && isset($_GET['tem']) && isset($_GET['umi'])) {
	$data = getTimersAndDataB();
	$date = getDataAtual();
	//$date = "12-06-2023";
	$hour = getHoraAtual();
	$dsem = date('w', strtotime($date));

	if($dsem == 0) { 
		$dsem = 'Dom'; 
	} else if($dsem == 1) { 
		$dsem = 'Seg'; 
	} else if($dsem == 2) { 
		$dsem = 'Ter'; 
	} else if($dsem == 3) { 
		$dsem = 'Qua'; 
	} else if($dsem == 4){ 
		$dsem = 'Qui'; 
	} else if($dsem == 5) { 
		$dsem = 'Sex'; 
	} else if($dsem == 6){ 
		$dsem = 'Sab'; 
	}

	$posb = [ [ 0 , 0 ] , [ false , false , false , false , false , false ] ];

	for($k = 0;$k < count($data);$k++) {
	    if($data[$k] -> IP == $_GET['ip']) {

		    $posb[0][0] = $k;
		    if($data[$k] -> STATS == "ON") { 
				$posb[1][0] = true; 
			}

			if(count($data[$k] -> DATAS) > 0){ 
				$posb[1][1] = true; 
			}

			if(count($data[$k] -> DATAB) > 0){ 
				$posb[1][2] = true; 
			}

			if($posb[1][1] == true) {
				for($i = 0;$i < count($data[$k] -> DATAS);$i++) {
					for($l = 0;$l < count($data[$k] -> DATAS[$i][0]);$l++) {
					    if($data[$k] -> DATAS[$i][0][$l] == $dsem) {
					         if(intval(explode(':',$hour)[0]) >= intval(explode(':' , $data[$k] -> DATAS[$i][1][0])[0]) 
							 	&& intval(explode(':',$hour)[0]) <= intval(explode(':' , $data[$k] -> DATAS[$i][1][1])[0])) { 
									$posb[1][3] = true; 
								}
						}
					}
				}
			}

			if($posb[1][2] == true) {
				for($i = 0;$i < count($data[$k] -> DATAB);$i++) {
				    if($data[$k] -> DATAB[$i][0] == $date)
					{
					    $posb[1][4] = true;
						$posb[0][1] = $i;
					}
				}
			}
		}
	}
	if($posb[1][0] == true) {
	    if($posb[1][2] == false) {
		    $data[$posb[0][0]] -> DATAB = [ [ $date , [ intval(explode('|',$_GET['tem'])[0]) ] , [ intval(explode('|',$_GET['tem'])[1]) ] , [ intval($_GET['umi']) ] , [ $hour ] ] ];
	        salvaDataB($data);
		} else if($posb[1][2] == true) {
            if($posb[1][4] == true) {
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][1][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][1])] = intval(explode('|',$_GET['tem'])[0]);
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][2][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][2])] = intval(explode('|',$_GET['tem'])[1]);
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][3][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][3])] = intval($_GET['umi']);
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][4][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][4])] = $hour;
				salvaDataB($data);
			} else if($posb[1][4] == false) {
				$data[$posb[0][0]] -> DATAB[$posb[0][1] + 1] = [ $date , [ intval(explode('|',$_GET['tem'])[0]) ] , [ intval(explode('|',$_GET['tem'])[1]) ] , [ intval($_GET['umi']) ] ,[ $hour] ];
				salvaDataB($data);
			}
		}
	} else if($posb[1][0] == false){
	    if($posb[1][2] == false && $posb[1][3] == true) {
		    $data[$posb[0][0]] -> DATAB = [ [ $date , [ intval(explode('|',$_GET['tem'])[0]) ] , [ intval(explode('|',$_GET['tem'])[1]) ] , [ intval($_GET['umi']) ] , [ $hour ] ] ];
	        salvaDataB($data);
		} else if($posb[1][2] == true && $posb[1][3] == true) {
		    if($posb[1][4] == true) {
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][1][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][1])] = intval(explode('|',$_GET['tem'])[0]);
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][2][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][2])] = intval(explode('|',$_GET['tem'])[1]);
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][3][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][3])] = intval($_GET['umi']);
				$data[$posb[0][0]] -> DATAB[$posb[0][1]][4][count($data[$posb[0][0]] -> DATAB[$posb[0][1]][4])] = $hour;
				salvaDataB($data);
			} else if($posb[1][4] == false) {
				$data[$posb[0][0]] -> DATAB[$posb[0][1] + 1] = [ $date , [ intval(explode('|',$_GET['tem'])[0]) ] , [ intval(explode('|',$hour)[1]) ] , [ intval($_GET['umi']) ] ,[ $hour ] ];
				salvaDataB($data);
			}
		}
	}
}
else if(isset($_GET['ip']) && isset($_GET['sta'])){
	$data = getTimers();
	if($_GET['sta'] == 'OFF'){
		$k = 0;
	    if($data[$k] -> IP == $_GET['ip']) { 
			$html = "ON";
			$data[$k] -> STATS = $_GET['sta']; 
			setTimers($data);
			echo json_encode($html);
		} 		
	} else if($_GET['sta'] == 'ON'){
	    $k = 0;
	    if($data[$k] -> IP == $_GET['ip']) { 
			$html = "OFF";
			$data[$k] -> STATS = $_GET['sta']; 
			setTimers($data);
			echo json_encode($html);
		} 		
	} else if($_GET['sta'] == 'CK'){
		$k = 0;	    
		if($data[$k] -> IP == $_GET['ip'])
		{
			if($data[$k] -> STATS == 'ON') {
				$html = "OFF";
			} else if($data[$k] -> STATS == 'OFF') {
				$html = "ON";
			}
		}		
		echo json_encode($html);
	} else if($_GET['sta'] == 'SH') {		
		$k = 0;

		if (isExisteTimer($data[0])) {
			if (isDataHoraAtualInTimer($data[0]->DATAS)) {
				$data[$k]->STATS = 'ON';
			} else {
				$data[$k]->STATS = 'OFF';
			}
			setTimers($data);
		}
		
		if($data[$k] -> IP == $_GET['ip']) {
			if($data[$k] -> STATS == 'ON') { 
				$html = 'ON'; 
			}
			else if($data[$k] -> STATS == 'OFF'){ 
				$html = 'OFF'; 
			}
		}
		
		echo $html;
	}
}
else if(isset($_GET['ip']) && isset($_GET['day']) && isset($_GET['hrs']) && isset($_GET['info'])) {
    if($_GET['info'] == 'prox') {
	    $data = getTimers();
	    $date = str_replace('/','-' , $_GET['day']);
		$date = date('w', strtotime($date));
			 if($date == 0){ $date = 'Dom'; }
		else if($date == 1){ $date = 'Seg'; }
		else if($date == 2){ $date = 'Ter'; }
		else if($date == 3){ $date = 'Qua'; }
		else if($date == 4){ $date = 'Qui'; }
		else if($date == 5){ $date = 'Sex'; }
		else if($date == 6){ $date = 'Sab'; }
		$dpos = 0;
		//$mpos = [ 0 , 0 ];
		$bool = 0;
		//$diffs = [];
	    for($k = 0;$k < count($data);$k++)
	    {
	        if($data[$k] -> IP == $_GET['ip'])
		    {
			    //$mpos[0] = $k;
				for($i = 0;$i < count($data[$k] -> DATAS);$i++)
				{
				    for($l = 0;$l < count($data[$k] -> DATAS[$i][0]);$l++)
				    {
				        if($date == $data[$k] -> DATAS[$i][0][$l])
					    {
						    //$diffs[$dpos] = [ intval(explode(':' , $data[$k] -> DATAS[$i][1][0])[0]) , intval(explode(':' , $data[$k] -> DATAS[$i][1][1])[0]) ];
                            //$dpos++;
							if(intval(explode(':' , $_GET['hrs'])[0]) >= intval(explode(':' , $data[$k] -> DATAS[$i][1][0])[0]) && intval(explode(':' , $_GET['hrs'])[0]) <= intval(explode(':' , $data[$k] -> DATAS[$i][1][1])[0]))
                            {
							    $bool = 1;
								break;
							}
						}
					}
					if($bool == 1){ break; }
				}
			}
		}
		echo $bool;
	}
}
else if(isset($_GET['ip']) && isset($_GET['clock'])) {
    if($_GET['clock'] == 'date') {
		$date = date('H:i*d:m:Y');
		$date =
		[
		    intval(trim(explode(':' , explode('*' , $date)[0])[0])),
		    intval(trim(explode(':' , explode('*' , $date)[0])[1])),
		    intval(trim(explode(':' , explode('*' , $date)[1])[0])),
		    intval(trim(explode(':' , explode('*' , $date)[1])[1])),
		    intval(trim(explode(':' , explode('*' , $date)[1])[2]))
		];
		$str = "";
		for($k = 0;$k < count($date);$k++){ 
			$str .= $date[$k].'|'; 
		}
		echo substr($str , 0 , -1);
	}
} else if(isset($_GET['ip']) && isset($_GET['info'])) {
    if($_GET['info'] == 'clean') {
	    $data = array("IP" => "0.0.0.0", "DATAS" => [],"STATS"=>"OFF");
        $data = [ $data ];
		$file = 'data.json';
		$json = json_encode($data);
		$file = fopen('data.json','w');
		fwrite($file, $json);
		fclose($file);
	} else if($_GET['info'] == 'json') {
        $file = fopen ('data.json', 'r');
        while(!feof($file))
        {
			$line = fgets($file);
			echo $line.'</br>';
        }
        fclose($file);
	}
}

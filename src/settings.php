<?php
require_once '../vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');
$html = [];

if(isset($_GET['ip']) && isset($_GET['days']) && isset($_GET['hours']))
{
	$data = getTimers();
	$posv = 0;
	$posb = [ 0 , [ false , false , false ] , [] ];
	for($k = 0;$k < count($data);$k++)
	{
	    if($data[$k] -> IP == $_GET['ip'])
		{
		    if(count($data[$k] -> DATAS) > 0)
		    {
			    $posb[0] = $k;
			    $posb[1][0] = true;
				for($i = 0;$i < count($data[$k] -> DATAS);$i++)
				{
				    $ds = explode('|' , $_GET['days']);
					for($l = 0;$l < count($data[$k] -> DATAS[$i][0]);$l++)
				    {
					    for($j = 0;$j < count($ds);$j++){ if($ds[$j] == $data[$k] -> DATAS[$i][0][$l]){ $posb[1][1] = true;break; } }
					    if($posb[1][1] == true){ break; }
					}
					$hs = explode('|' , $_GET['hours']);
					for($l = 0;$l < count($hs);$l++){ $hs[$l] = explode(':' , $hs[$l]); }
					if($posb[1][1] == true)
					{
						if(intval($hs[0][0]) >= intval(explode(':' , $data[$k] -> DATAS[$i][1][0])[0]) && intval($hs[0][0]) <= intval(explode(':' , $data[$k] -> DATAS[$i][1][1])[0]))
						{
						    $posb[1][2] = true;
							$posb[2][$posv] = $i;
							$posv++;
						}
						else if(intval($hs[1][0]) >= intval(explode(':' , $data[$k] -> DATAS[$i][1][0])[0]) && intval($hs[1][0]) <= intval(explode(':' , $data[$k] -> DATAS[$i][1][1])[0]))
						{
						    $posb[1][2] = true;
							$posb[2][$posv] = $i;
							$posv++;
						}
					}
				}
			}
			else if(count($data[$k] -> DATAS) == 0)
			{
				$posb[0] = $k;
				break;
			}
		}
	}
	if($posb[1][0] == false)
	{
	    $data[$posb[0]] -> DATAS = [ [ explode('|',$_GET['days']) ,  explode('|',$_GET['hours']) ] ];
		setTimers($data);
	}
	else if($posb[1][0] == true)
	{
	    if($posb[1][2] == false)
		{
		    $data[$posb[0]] -> DATAS[count($data[$posb[0]] -> DATAS)] = [ explode('|',$_GET['days']) ,  explode('|',$_GET['hours']) ];
			setTimers($data);
		}
	}
	if(count($posb[2]) > 0){ echo json_encode($posb[2]); }
	else if(count($posb[2]) == 0){ echo json_encode('null'); }
}

if(isset($_GET['ip']) and isset($_GET['ggraphs']))
{    
	$data = getTimersAndDataB();
    $grap = explode('|' , $_GET['ggraphs']);
	$inf = [];
	for($k = 0;$k < count($data);$k++)
	{
	    if($data[$k] -> IP == $_GET['ip'])
		{
			if(count($data[$k] -> DATAB) > 0)
			{
				for($i = 0;$i < count($data[$k] -> DATAB);$i++)
			    {
				    if($data[$k] -> DATAB[$i][0] == $grap[0])
					{
					    $inf[0] = $data[$k] -> DATAB[$i][1];
					    $inf[1] = $data[$k] -> DATAB[$i][2];
					    $inf[2] = $data[$k] -> DATAB[$i][3];
						$inf[3] = $data[$k] -> DATAB[$i][4];
					}
				}
			}
		}
	}
	if(count($inf) > 0)
	{
	    $inf[0] = vSTR($inf[0]);
	    $inf[1] = vSTR($inf[1]);
	    $inf[2] = vSTR($inf[2]);
		$inf[3] = str_replace(',' , '" , "' , vSTR($inf[3]));
		$inf[3] = '[ "'.$inf[3].'" ]';
	    $inf[4] = '';
	}
	else if(count($inf) == 0)
	{
	    $inf[0] = ' 0 ';
	    $inf[1] = ' 0 ';
	    $inf[2] = ' 0 ';
		$inf[3] = '';
	    $inf[4] = 'console.log("NÃO HÁ RESULTADOS!");';
	}
    $html[0] =
    '<script>
	'.$inf[4].'
	 days = '.$inf[3].';
	 tem1 = ['.$inf[0].'];
	 tem2 = ['.$inf[1].'];
	 umi1 = ['.$inf[2].'];
	 new Chart("graph",
	 {
	 	 type: "line",
	 	 data:
		 {
			 labels: days,
			 datasets:
			 [{
				 fill: false,
				 lineTension: 0,
				 backgroundColor: "rgba(0,0,255,1.0)",
				 borderColor: "rgba(0,0,255,1.0)",
				 data: tem1
			 },
			 {
				 fill: false,
				 lineTension: 0,
				 backgroundColor: "rgba(0,255,0,1.0)",
				 borderColor: "rgba(0,255,0,1.0)",
				 data: tem2
			 },
			 {
				 fill: false,
				 lineTension: 0,
				 backgroundColor: "rgba(255,0,0,1.0)",
				 borderColor: "rgba(255,0,0,1.0)",
				 data: umi1
			 }]
		 },
		 options:
		 {
			 legend: {display: false},
			 scales: { yAxes: [{ticks: { min: 0, max:35 }}], }
		 }
	});
	</script>';
    echo json_encode($html);
}


else if(isset($_GET['ip']) && isset($_GET['info'])) {
    if($_GET['info'] == 'BANNER') {
		
		$data = getUltimaAtualizacao();
		
		if(count($data) > 0)
		{
			$dtTemperatura = $data[0];
			$tempInterna = end($data[1]);
			$tempExterna = end($data[2]);
			$umidade = end($data[3]);

			$html[0] =
			'<a style="width:100%;height:42px;position:absolute;margin-top:12px;margin-left:0px;color:Black;text-align:center;font-family:Helvetica;line-height:62px;font-size:42px;">'.$dtTemperatura.'</a>
				<a style="width:100%;height:42px;position:absolute;margin-top:70px;margin-left:0px;color:Black;text-align:center;font-family:Helvetica;line-height:62px;font-size:25px;">Temperatura Interna ' . $tempInterna .'°</a>
				<a style="width:100%;height:42px;position:absolute;margin-top:102px;margin-left:0px;color:Black;text-align:center;font-family:Helvetica;line-height:62px;font-size:25px;">Temperatura Externa ' . $tempExterna .'°</a>
				<a style="width:100%;height:42px;position:absolute;margin-top:135px;margin-left:0px;color:Black;text-align:center;font-family:Helvetica;line-height:62px;font-size:25px;">Umidade '. $umidade . '%</a>';
				
		}else {
			$html[0] = '<div style="width:100%;height:42px;position:absolute;margin-top:12px;margin-left:0px;color:Black;text-align:center;font-family:Helvetica;line-height:62px;font-size:25px;">Nenhuma informação disponível</div>';
		}			
		
	} else {
		if($_GET['info'] == 'TIMERS')
		{		    
		    $data = getTimers();

		    $eqls = [];
            if($_GET['eqls'] != '0'){ $eqls = explode('|', $_GET['eqls']); }
			for($k = 0;$k < count($eqls);$k++){$eqls[$k] = intval($eqls[$k]); }
			//$json = file_get_contents("../data/data.json");
			//$data = json_decode($json);
			$html[0] = '<div style="width:854px;height:30px;margin: 5px;background-color:White;border:none;font-family:Helvetica;font-size:16px;text-align:left;color:Black;text-align:center">TIMER</div>';
			for($k = 0;$k < count($data);$k++)
			{
				if($data[$k] -> IP == $_GET['ip'])
				{
					for($i = 0;$i < count($data[$k] -> DATAS);$i++)
					{
						$sem = '';
						$hrs = '';
						$hex = [ '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' ];
						for($l = 0;$l < count($data[$k] -> DATAS[$i][0]);$l++)
						{
								 if($data[$k] -> DATAS[$i][0][$l] == 'Seg'){ $hex[0] = '#F44336'; }
							else if($data[$k] -> DATAS[$i][0][$l] == 'Ter'){ $hex[1] = '#F44336'; }
							else if($data[$k] -> DATAS[$i][0][$l] == 'Qua'){ $hex[2] = '#F44336'; }
							else if($data[$k] -> DATAS[$i][0][$l] == 'Qui'){ $hex[3] = '#F44336'; }
							else if($data[$k] -> DATAS[$i][0][$l] == 'Sex'){ $hex[4] = '#F44336'; }
							else if($data[$k] -> DATAS[$i][0][$l] == 'Sab'){ $hex[5] = '#F44336'; }
							else if($data[$k] -> DATAS[$i][0][$l] == 'Dom'){ $hex[6] = '#F44336'; }
							$sem .= $data[$k] -> DATAS[$i][0][$l].'|';
						}
						for($l = 0;$l < count($data[$k] -> DATAS[$i][1]);$l++){ $hrs .= $data[$k] -> DATAS[$i][1][$l].'|'; }
						$hrs = substr($hrs , 0 , -1);
						$sem = substr($sem , 0 , -1);
						$html[$i + 1] =
						'<div class="e-cont-se">
							<div class="e-cont-selb" style="margin-left:20px">
								<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][0])[0].'" class="e-cont-val1"/>
								<label class="e-cont-sepr">:</label>
								<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][0])[1].'" class="e-cont-val2"/>
							</div>
							<div class="e-cont-selb" style="margin-left:122px">
								<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][1])[0].'" class="e-cont-val1"/>
								<label class="e-cont-sepr">:</label>
								<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][1])[1].'" class="e-cont-val2"/>
							</div>
							<a class="e-cont-comb" style="margin-left:308px;background-color:'.$hex[0].';">Seg</a>
							<a class="e-cont-comb" style="margin-left:356px;background-color:'.$hex[1].';">Ter</a>
							<a class="e-cont-comb" style="margin-left:404px;background-color:'.$hex[2].';">Qua</a>
							<a class="e-cont-comb" style="margin-left:452px;background-color:'.$hex[3].';">Qui</a>
							<a class="e-cont-comb" style="margin-left:500px;background-color:'.$hex[4].';">Sex</a>
							<a class="e-cont-comb" style="margin-left:548px;background-color:'.$hex[5].';">Sab</a>
							<a class="e-cont-comb" style="margin-left:596px;background-color:'.$hex[6].';">Dom</a>
							<a class="fa fa-trash" onclick="Del(['."'".$sem."'".','."'".$hrs."'".'])"></a>
							<input type="button" name="btn-save" id="btn-save" onclick="Save()" value="SAVE" class="btn-save" style="background-color:#D2D2D2">
						</div>';
					}
				}
			}
		}
		if(count($html) > 1)
		{
			$html[count($html)] =
			'<div class="e-cont-se-end">
				<div class="e-cont-selb" style="margin-left:15px">
					<input type="text" id="e-cont-val1-hrs" value="00" class="e-cont-val1"/>
					<label class="e-cont-sepr">:</label>
					<input type="text" id="e-cont-val1-min" value="00" class="e-cont-val2"/>
					<input type="button" value="-" onchange="setHR('."'-'".',1)" onclick="setHR('."'-'".',1)" class="e-cont-vbtn" style="margin-left:-10px;"/>
					<input type="button" value="+" onchange="setHR('."'+'".',1)" onclick="setHR('."'+'".',1)" class="e-cont-vbtn" style="right:-10px;"/>
				</div>
				<div class="e-cont-selb" style="margin-left:142px">
					<input type="text" id="e-cont-val2-hrs" value="00" class="e-cont-val1"/>
					<label class="e-cont-sepr">:</label>
					<input type="text" id="e-cont-val2-min" value="00" class="e-cont-val2"/>
					<input type="button" value="-" onchange="setHR('."'-'".',2)" onclick="setHR('."'-'".',2)" class="e-cont-vbtn" style="margin-left:-10px;"/>
					<input type="button" value="+" onchange="setHR('."'+'".',2)" onclick="setHR('."'+'".',2)" class="e-cont-vbtn" style="right:-10px;"/>
				</div>
				<a id="e-cont-comb1" class="e-cont-comb" onclick="setDAY(1)" style="margin-left:308px;background-color:#018EE8;">Seg</a>
				<a id="e-cont-comb2" class="e-cont-comb" onclick="setDAY(2)" style="margin-left:356px;background-color:#018EE8;">Ter</a>
				<a id="e-cont-comb3" class="e-cont-comb" onclick="setDAY(3)" style="margin-left:404px;background-color:#018EE8;">Qua</a>
				<a id="e-cont-comb4" class="e-cont-comb" onclick="setDAY(4)" style="margin-left:452px;background-color:#018EE8;">Qui</a>
				<a id="e-cont-comb5" class="e-cont-comb" onclick="setDAY(5)" style="margin-left:500px;background-color:#018EE8;">Sex</a>
				<a id="e-cont-comb6" class="e-cont-comb" onclick="setDAY(6)" style="margin-left:548px;background-color:#018EE8;">Sab</a>
				<a id="e-cont-comb7" class="e-cont-comb" onclick="setDAY(7)" style="margin-left:596px;background-color:#018EE8;">Dom</a>
				<input type="button" name="btn-save" id="btn-save" onclick="Save()" value="SAVE" class="btn-save" style="background-color:#018EE8">
			</div>';
		}
		else
		{
			$html[1] =
			'<div class="e-cont-se-end">
				<div class="e-cont-selb" style="margin-left:15px">
					<input type="text" id="e-cont-val1-hrs" value="00" class="e-cont-val1"/>
					<label class="e-cont-sepr">:</label>
					<input type="text" id="e-cont-val1-min" value="00" class="e-cont-val2"/>
					<input type="button" value="-" onchange="setHR('."'-'".',1)" onclick="setHR('."'-'".',1)" class="e-cont-vbtn" style="margin-left:-10px;"/>
					<input type="button" value="+" onchange="setHR('."'+'".',1)" onclick="setHR('."'+'".',1)" class="e-cont-vbtn" style="right:-10px;"/>
				</div>
				<div class="e-cont-selb" style="margin-left:142px">
					<input type="text" id="e-cont-val2-hrs" value="00" class="e-cont-val1"/>
					<label class="e-cont-sepr">:</label>
					<input type="text" id="e-cont-val2-min" value="00" class="e-cont-val2"/>
					<input type="button" value="-" onchange="setHR('."'-'".',2)" onclick="setHR('."'-'".',2)" class="e-cont-vbtn" style="margin-left:-10px;"/>
					<input type="button" value="+" onchange="setHR('."'+'".',2)" onclick="setHR('."'+'".',2)" class="e-cont-vbtn" style="right:-10px;"/>
				</div>
				<a id="e-cont-comb1" class="e-cont-comb" onclick="setDAY(1)" style="margin-left:308px;background-color:#018EE8;">Seg</a>
				<a id="e-cont-comb2" class="e-cont-comb" onclick="setDAY(2)" style="margin-left:356px;background-color:#018EE8;">Ter</a>
				<a id="e-cont-comb3" class="e-cont-comb" onclick="setDAY(3)" style="margin-left:404px;background-color:#018EE8;">Qua</a>
				<a id="e-cont-comb4" class="e-cont-comb" onclick="setDAY(4)" style="margin-left:452px;background-color:#018EE8;">Qui</a>
				<a id="e-cont-comb5" class="e-cont-comb" onclick="setDAY(5)" style="margin-left:500px;background-color:#018EE8;">Sex</a>
				<a id="e-cont-comb6" class="e-cont-comb" onclick="setDAY(6)" style="margin-left:548px;background-color:#018EE8;">Sab</a>
				<a id="e-cont-comb7" class="e-cont-comb" onclick="setDAY(7)" style="margin-left:596px;background-color:#018EE8;">Dom</a>
				<input type="button" name="btn-save" id="btn-save" onclick="Save()" value="SAVE" class="btn-save" style="background-color:#018EE8">
			</div>';
		}
	}
    echo json_encode($html);
}
else if(isset($_GET['ip']) && isset($_GET['day']) && isset($_GET['hrs']))
{
	$data = getTimers();
	$pos = [ 0 , 0 ];
	$datas = [];
	$ds = explode('|',$_GET['day']);
	$hs = explode('|',$_GET['hrs']);
	for($k = 0;$k < count($data);$k++)
	{
	    if($data[$k] -> IP == $_GET['ip'])
	    {
	        $pos[1] = $k;
	        for($i = 0;$i < count($data[$k] -> DATAS);$i++)
			{
				if(vSTR($ds) != vSTR($data[$k] -> DATAS[$i][0]) or vSTR($hs) != vSTR($data[$k] -> DATAS[$i][1]))
				{
					$datas[$pos[0]] = $data[$k] -> DATAS[$i];
					$pos[0]++;
				}
			}
	    }
	}
	$data[$pos[1]] -> DATAS = $datas;
	setTimers($data);
	$html[0] = '<div style="width:854px;height:30px;margin: 5px;background-color:White;border:none;font-family:Helvetica;font-size:16px;text-align:left;color:Black;text-align:center">TIMER</div>';
	for($k = 0;$k < count($data);$k++)
	{
		if($data[$k] -> IP == $_GET['ip'])
		{
			for($i = 0;$i < count($data[$k] -> DATAS);$i++)
			{
				$sem = '';
				$hrs = '';
				$hex = [ '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' , '#018EE8' ];
				for($l = 0;$l < count($data[$k] -> DATAS[$i][0]);$l++)
				{
						 if($data[$k] -> DATAS[$i][0][$l] == 'Seg'){ $hex[0] = '#F44336'; }
					else if($data[$k] -> DATAS[$i][0][$l] == 'Ter'){ $hex[1] = '#F44336'; }
					else if($data[$k] -> DATAS[$i][0][$l] == 'Qua'){ $hex[2] = '#F44336'; }
					else if($data[$k] -> DATAS[$i][0][$l] == 'Qui'){ $hex[3] = '#F44336'; }
					else if($data[$k] -> DATAS[$i][0][$l] == 'Sex'){ $hex[4] = '#F44336'; }
					else if($data[$k] -> DATAS[$i][0][$l] == 'Sab'){ $hex[5] = '#F44336'; }
					else if($data[$k] -> DATAS[$i][0][$l] == 'Dom'){ $hex[6] = '#F44336'; }
					$sem .= $data[$k] -> DATAS[$i][0][$l].'|';
				}
				for($l = 0;$l < count($data[$k] -> DATAS[$i][1]);$l++){ $hrs .= $data[$k] -> DATAS[$i][1][$l].'|'; }
				$hrs = substr($hrs , 0 , -1);
				$sem = substr($sem , 0 , -1);
				$html[$i + 1] =
				'<div class="e-cont-se">
					<div class="e-cont-selb" style="margin-left:20px">
						<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][0])[0].'" class="e-cont-val1"/>
						<label class="e-cont-sepr">:</label>
						<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][0])[1].'" class="e-cont-val2"/>
					</div>
					<div class="e-cont-selb" style="margin-left:122px">
						<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][1])[0].'" class="e-cont-val1"/>
						<label class="e-cont-sepr">:</label>
						<input type="text" value="'.explode(':',$data[$k] -> DATAS[$i][1][1])[1].'" class="e-cont-val2"/>
					</div>
					<a class="e-cont-comb" style="margin-left:308px;background-color:'.$hex[0].';">Seg</a>
					<a class="e-cont-comb" style="margin-left:356px;background-color:'.$hex[1].';">Ter</a>
					<a class="e-cont-comb" style="margin-left:404px;background-color:'.$hex[2].';">Qua</a>
					<a class="e-cont-comb" style="margin-left:452px;background-color:'.$hex[3].';">Qui</a>
					<a class="e-cont-comb" style="margin-left:500px;background-color:'.$hex[4].';">Sex</a>
					<a class="e-cont-comb" style="margin-left:548px;background-color:'.$hex[5].';">Sab</a>
					<a class="e-cont-comb" style="margin-left:596px;background-color:'.$hex[6].';">Dom</a>
					<a class="fa fa-trash" onclick="Del(['."'".$sem."'".','."'".$hrs."'".'])"></a>
					<input type="button" name="btn-save" id="btn-save" onclick="Save()" value="SAVE" class="btn-save" style="background-color:#D2D2D2">
				</div>';
			}
		}
	}
	if(count($html) > 1)
	{
		$html[count($html)] =
		'<div class="e-cont-se-end">
			<div class="e-cont-selb" style="margin-left:15px">
				<input type="text" id="e-cont-val1-hrs" value="00" class="e-cont-val1"/>
				<label class="e-cont-sepr">:</label>
				<input type="text" id="e-cont-val1-min" value="00" class="e-cont-val2"/>
				<input type="button" value="-" onchange="setHR('."'-'".',1)" onclick="setHR('."'-'".',1)" class="e-cont-vbtn" style="margin-left:-10px;"/>
				<input type="button" value="+" onchange="setHR('."'+'".',1)" onclick="setHR('."'+'".',1)" class="e-cont-vbtn" style="right:-10px;"/>
			</div>
			<div class="e-cont-selb" style="margin-left:142px">
				<input type="text" id="e-cont-val2-hrs" value="00" class="e-cont-val1"/>
				<label class="e-cont-sepr">:</label>
				<input type="text" id="e-cont-val2-min" value="00" class="e-cont-val2"/>
				<input type="button" value="-" onchange="setHR('."'-'".',2)" onclick="setHR('."'-'".',2)" class="e-cont-vbtn" style="margin-left:-10px;"/>
				<input type="button" value="+" onchange="setHR('."'+'".',2)" onclick="setHR('."'+'".',2)" class="e-cont-vbtn" style="right:-10px;"/>
			</div>
			<a id="e-cont-comb1" class="e-cont-comb" onclick="setDAY(1)" style="margin-left:308px;background-color:#018EE8;">Seg</a>
			<a id="e-cont-comb2" class="e-cont-comb" onclick="setDAY(2)" style="margin-left:356px;background-color:#018EE8;">Ter</a>
			<a id="e-cont-comb3" class="e-cont-comb" onclick="setDAY(3)" style="margin-left:404px;background-color:#018EE8;">Qua</a>
			<a id="e-cont-comb4" class="e-cont-comb" onclick="setDAY(4)" style="margin-left:452px;background-color:#018EE8;">Qui</a>
			<a id="e-cont-comb5" class="e-cont-comb" onclick="setDAY(5)" style="margin-left:500px;background-color:#018EE8;">Sex</a>
			<a id="e-cont-comb6" class="e-cont-comb" onclick="setDAY(6)" style="margin-left:548px;background-color:#018EE8;">Sab</a>
			<a id="e-cont-comb7" class="e-cont-comb" onclick="setDAY(7)" style="margin-left:596px;background-color:#018EE8;">Dom</a>
			<input type="button" name="btn-save" id="btn-save" onclick="Save()" value="SAVE" class="btn-save" style="background-color:#018EE8">
		</div>';
	}
	else
	{
		$html[1] =
		'<div class="e-cont-se-end">
			<div class="e-cont-selb" style="margin-left:15px">
				<input type="text" id="e-cont-val1-hrs" value="00" class="e-cont-val1"/>
				<label class="e-cont-sepr">:</label>
				<input type="text" id="e-cont-val1-min" value="00" class="e-cont-val2"/>
				<input type="button" value="-" onchange="setHR('."'-'".',1)" onclick="setHR('."'-'".',1)" class="e-cont-vbtn" style="margin-left:-10px;"/>
				<input type="button" value="+" onchange="setHR('."'+'".',1)" onclick="setHR('."'+'".',1)" class="e-cont-vbtn" style="right:-10px;"/>
			</div>
			<div class="e-cont-selb" style="margin-left:142px">
				<input type="text" id="e-cont-val2-hrs" value="00" class="e-cont-val1"/>
				<label class="e-cont-sepr">:</label>
				<input type="text" id="e-cont-val2-min" value="00" class="e-cont-val2"/>
				<input type="button" value="-" onchange="setHR('."'-'".',2)" onclick="setHR('."'-'".',2)" class="e-cont-vbtn" style="margin-left:-10px;"/>
				<input type="button" value="+" onchange="setHR('."'+'".',2)" onclick="setHR('."'+'".',2)" class="e-cont-vbtn" style="right:-10px;"/>
			</div>
			<a id="e-cont-comb1" class="e-cont-comb" onclick="setDAY(1)" style="margin-left:308px;background-color:#018EE8;">Seg</a>
			<a id="e-cont-comb2" class="e-cont-comb" onclick="setDAY(2)" style="margin-left:356px;background-color:#018EE8;">Ter</a>
			<a id="e-cont-comb3" class="e-cont-comb" onclick="setDAY(3)" style="margin-left:404px;background-color:#018EE8;">Qua</a>
			<a id="e-cont-comb4" class="e-cont-comb" onclick="setDAY(4)" style="margin-left:452px;background-color:#018EE8;">Qui</a>
			<a id="e-cont-comb5" class="e-cont-comb" onclick="setDAY(5)" style="margin-left:500px;background-color:#018EE8;">Sex</a>
			<a id="e-cont-comb6" class="e-cont-comb" onclick="setDAY(6)" style="margin-left:548px;background-color:#018EE8;">Sab</a>
			<a id="e-cont-comb7" class="e-cont-comb" onclick="setDAY(7)" style="margin-left:596px;background-color:#018EE8;">Dom</a>
			<input type="button" name="btn-save" id="btn-save" onclick="Save()" value="SAVE" class="btn-save" style="background-color:#018EE8">
		</div>';
	}
    echo json_encode($html);
}
else
{
    /*GET INVALID*/
}
function vSTR($s)
{
    $str = '';
    for($k = 0;$k < count($s);$k++){ $str .= $s[$k].','; }
	$str = substr($str,0,-1);
	return $str;
}
?>
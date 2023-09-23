<html>
<head>
</head>
<body>
    <center>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&day=12/12/2022&hrs=12:00&tem=<?php echo rand(5, 30);?>|<?php echo rand(5, 30);?>&umi=<?php echo rand(5, 30);?>">SET ARDUINO TEMPERATURA E UMIDADE</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&sta=ON">SET ARDUINO ON - OFF</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&sta=CK">SET SITE ON - OFF</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&sta=SH">GET ARDUINO STATUS</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&day=21/11/2022&hrs=01:00&info=prox">GET ARDUINO VETOR TEMPO START E BREAK</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&info=clean">SITE REINICIAR JSON</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&info=json">SITE CONTEUDO JSON</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&clock=date">ARDUINO CLOCK</a>
		</br>
		<a href="src/ard-cnnx.php?ip=0.0.0.0&day=12/12/2022&hrs=12:00&tem=<?php echo $_POST['temperaturaDHT'];?>|<?php echo $_POST['temperaturaDS18B20'];?>&umi=<?php echo $_POST['umidadeDHT'];?>" > GET PARA ARDUINO ADICIONAR DADOS</a>
	</center>	
</body>
</html>
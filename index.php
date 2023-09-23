<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="keywords" content="Clima-Geo">
	<title>Clima-Geo</title>
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript">
		$(document).ready(function() {
			$('#btn-tm').on('click', function() {
				window.location = 'src/timer.php';
			});
			$('#btn-gp').on('click', function() {
				window.location = 'src/graph.php';
			});
		});

		
		setInterval(() => {
			var html = '';
			$.ajax({
				url: 'src/settings.php',
				type: 'GET',
				dataType: 'json',
				cache: false,
				data: {
					ip: '0.0.0.0',
					info: 'BANNER',
				},
				contentType: false,
				beforeSend: function() {
					document.getElementById("load-gif").style.display = "block";
				},
				complete: function() {
					document.getElementById("load-gif").style.display = "none";
				},
				success: function(a) {
					$(".e-cont-info").html("");
					for (var k = 0; k < a.length; k++) {
						$(".e-cont-info").append(a[k]);
					}
				},
				error: function(request, status, error) {
					console.log(request.responseText);
				}
			});
		}, 10000);

		function ard(status) {
			$.ajax({
				url: 'src/ard-cnnx.php',
				type: 'GET',
				dataType: 'json',
				cache: false,
				data: {
					ip: '0.0.0.0',
					sta: status
				},
				contentType: false,
				success: function(a) {
					if (a == "OFF") {
						document.getElementById("btn-on").style.display = "block";
						document.getElementById("btn-off").style.display = "none";
					} else if (a == "ON") {
						document.getElementById("btn-off").style.display = "block";
						document.getElementById("btn-on").style.display = "none";
					}
				},
				error: function(request, status, error) {
					console.log(request.responseText);
				}
			});
		}
	</script>
</head>

<body onload="ard('CK');">
	<div class="e-menu">
		<div class="e-menu-ie"></div>
		<a href="href.php" style="width:120px;height:50%;position:absolute;margin-top:10px;right:0px;font-size:40px;text-align:center;color:#D2D1D0">&#9881;</a>
	</div>
	<div class="e-cont">
		<img src="img/load.gif" id="load-gif" class="e-cont-gf" style="display: none;">
		<div class="e-cont-te">Climatizador Geotérmico</div>
		<div id="e-cont-info" class="e-cont-info"></div>
		<div id="btn-on" class="e-cont-on" style="display: none;">
			<input type="image" src="img/1377269.svg" id="img-on" onclick="ard('OFF')" class="e-cont-ie" />
			<a class="e-cont-a">OFF</a>
		</div>
		<div id="btn-off" class="e-cont-on" style="display: none;">
			<input type="image" src="img/3686918.svg" id="img-off" onclick="ard('ON')" class="e-cont-ie" />
			<a class="e-cont-a">ON</a>
		</div>
		<div id="btn-tm" class="e-cont-tm">
			<span class="e-cont-sp">
				<img src="img/3867499.png" class="e-cont-ie">
			</span>
			<a class="e-cont-a">TIMER</a>
		</div>
		<div id="btn-gp" class="e-cont-gp">
			<span class="e-cont-sp">
				<img src="img/2065169.png" class="e-cont-ie">
			</span>
			<a class="e-cont-a">GRAPH</a>
		</div>
	</div>
	<div class="e-footer">
		<a style="width:100%;height:20px;position:absolute;bottom:5px;margin-left:0px;font-family:Helvetica;font-size:13px;text-align:center;color:White">Todos direitos reservados para Clima-Geo.com</a>
	</div>
</body>

</html>
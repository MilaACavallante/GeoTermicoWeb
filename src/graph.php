<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="../css/graph.css" media="screen">
	<script class="u-script" type="text/javascript" src="../js/jquery-3.4.1.min.js" defer=""></script>
	<script src="../js/Chart.min.js"></script>
</head>

<body>
	<div class="e-back"></div>
	<div class="e-graphs">
		<canvas id="graph" style="position:absolute;margin-left:0px;margin-top:18px;"></canvas>
		<div style="width:30px;height:15px;position:absolute;bottom:8px;margin-left:4px;background-color:rgba(0,0,255,1.0)">
			<a style="width:130px;height:15px;position:absolute;bottom:0px;margin-left:34px;color:Silver">Temp Intena 1</a>
		</div>
		<div style="width:30px;height:15px;position:absolute;bottom:8px;margin-left:144px;background-color:rgba(0,255,0,1.0)">
			<a style="width:130px;height:15px;position:absolute;bottom:0px;margin-left:34px;color:Silver">Temp Externa 2</a>
		</div>
		<div style="width:30px;height:15px;position:absolute;bottom:8px;margin-left:292px;background-color:rgba(255,0,0,1.0)">
			<a style="width:130px;height:15px;position:absolute;bottom:0px;margin-left:34px;color:Silver">Umidade</a>
		</div>
	</div>
	<div class="e-data-sl">
		<form style="width:100%;height:100%;position:absolute;margin-top:0px;margin-left:0px">
			<input type="date" placeholder="Data" id="email-ef64" name="Data" class="e-graph-data" required="required">
			<a class="e-data-sun">&#9788;</a>
			<input type="button" value="Buscar" onclick="getGRAPHS()" class="e-graph-btn">
		</form>
	</div>
	<input type="image" src="../img/2099190.png" onclick="RET()" class="e-ret-ie" />
</body>
<script>
	var days = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"];
	var tem1 = [0];
	var tem2 = [0];
	var umi1 = [0];
	new Chart("graph", {
		type: "line",
		data: {
			labels: days,
			datasets: [{
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
				}
			]
		},
		options: {
			legend: {
				display: false
			},
			scales: {
				yAxes: [{
					ticks: {
						min: 0,
						max: 100
					}
				}],
			}
		}
	});
	const _date = new Date();
	document.getElementById('email-ef64').value = _date.toISOString().substring(0, 10);

	function RET() {
		window.location = '../';
	}

	function getGRAPHS() {
		$.ajax({
			url: 'settings.php',
			type: 'GET',
			dataType: 'json',
			cache: false,
			data: {
				ip: '0.0.0.0',
				ggraphs: document.getElementById('email-ef64').value.split('-')[2] + '-' + document.getElementById('email-ef64').value.split('-')[1] + '-' + document.getElementById('email-ef64').value.split('-')[0] + '|' + _date.toUTCString().substring(0, 3),
			},
			contentType: false,
			success: function(a) {
				for (var k = 0; k < a.length; k++) {
					$("body").append(a[k]);
				}
			},
			error: function(request, status, error) {
				console.log(request.responseText);
			}
		});
	}
</script>

</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Timer</title>
    <link rel="stylesheet" href="../css/timer.css" media="screen">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
	<script>
	$(document).ready(function ()
    {
		$.ajax({
			url: 'settings.php',
			type: 'GET',
			dataType: 'json',
			cache: false,
			data:
			{
				ip:'0.0.0.0',
				info: 'TIMERS',
				eqls: '0'
			},
			contentType: false,
			timeout: 8000,
			success: function(a){ for(var k = 0;k < a.length;k++){ $(".e-cont-dates").append(a[k]); } },
			error: function (request, status, error){ console.log(request.responseText); }
		});
	});
	function RET(){ window.location='../'; }
	function Del(v)
	{
	    var html = '';
		$.ajax({
			url: 'settings.php',
			type: 'GET',
			dataType: 'json',
			cache: false,
			data:
			{
				ip:'0.0.0.0',
				day: v[0],
			    hrs: v[1]
			},
			contentType: false,
			timeout: 8000,
			success: function(a){ for(var k = 0;k < a.length;k++){ $(".e-cont-dates").append(a[k]); } },
			error: function (request, status, error){ console.log(request.responseText); }
		});
		$.ajax({
			url: 'settings.php',
			type: 'GET',
			dataType: 'json',
			cache: false,
			data:
			{
				ip:'0.0.0.0',
				info: 'TIMERS',
				eqls: '0'
			},
			contentType: false,
			timeout: 8000,
			success: function(a){ for(var k = 0;k < a.length;k++){ html += a[k]; } },
			error: function (request, status, error){ console.log(request.responseText); }
		});
		document.getElementById('e-cont-dates').innerHTML = html;
	}
	function setHR(s,e)
	{
	    /*if(e == 1)
		{
		    if(s == '-')
			{
			    if(parseInt(document.getElementById('e-cont-val1-min').value) == 0)
				{
				    document.getElementById('e-cont-val1-min').value = '00';
				    if(parseInt(document.getElementById('e-cont-val1-hrs').value) < 9 && parseInt(document.getElementById('e-cont-val1-hrs').value) > 0){ document.getElementById('e-cont-val1-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val1-hrs').value) - 1); }
                    else if(parseInt(document.getElementById('e-cont-val1-hrs').value) >= 9){ document.getElementById('e-cont-val1-hrs').value = (parseInt(document.getElementById('e-cont-val1-hrs').value) - 1); }
				}
				else if(parseInt(document.getElementById('e-cont-val1-min').value) > 0)
				{
				    if(parseInt(document.getElementById('e-cont-val1-min').value) < 9){ document.getElementById('e-cont-val1-min').value = '0' + (parseInt(document.getElementById('e-cont-val1-min').value) - 1); }
                    else if(parseInt(document.getElementById('e-cont-val1-min').value) >= 9){ document.getElementById('e-cont-val1-min').value = (parseInt(document.getElementById('e-cont-val1-min').value) - 1); }
				}
			}
		    else if(s == '+')
			{
			    if(parseInt(document.getElementById('e-cont-val1-min').value) == 59)
				{
				    document.getElementById('e-cont-val1-min').value = '00';
				    if(parseInt(document.getElementById('e-cont-val1-hrs').value) < 9){ document.getElementById('e-cont-val1-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val1-hrs').value) + 1); }
                    else if(parseInt(document.getElementById('e-cont-val1-hrs').value) >= 9 && parseInt(document.getElementById('e-cont-val1-hrs').value) < 23){ document.getElementById('e-cont-val1-hrs').value = (parseInt(document.getElementById('e-cont-val1-hrs').value) + 1); }
				    else if(parseInt(document.getElementById('e-cont-val1-hrs').value) == 23){ document.getElementById('e-cont-val1-hrs').value = '00'; }
				}
				else 
				{
				    if(parseInt(document.getElementById('e-cont-val1-min').value) < 9){ document.getElementById('e-cont-val1-min').value = '0' + (parseInt(document.getElementById('e-cont-val1-min').value) + 1); }
                    else if(parseInt(document.getElementById('e-cont-val1-min').value) >= 9){ document.getElementById('e-cont-val1-min').value = (parseInt(document.getElementById('e-cont-val1-min').value) + 1); }
				}
			}
		}
	    else if(e == 2)
		{
		    if(s == '-')
			{
			    if(parseInt(document.getElementById('e-cont-val2-min').value) == 0)
				{
				    document.getElementById('e-cont-val2-min').value = '00';
				    if(parseInt(document.getElementById('e-cont-val2-hrs').value) < 9 && parseInt(document.getElementById('e-cont-val2-hrs').value) > 0){ document.getElementById('e-cont-val2-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val2-hrs').value) - 1); }
                    else if(parseInt(document.getElementById('e-cont-val2-hrs').value) >= 9){ document.getElementById('e-cont-val2-hrs').value = (parseInt(document.getElementById('e-cont-val2-hrs').value) - 1); }
				}
				else if(parseInt(document.getElementById('e-cont-val2-min').value) > 0)
				{
				    if(parseInt(document.getElementById('e-cont-val2-min').value) < 9){ document.getElementById('e-cont-val2-min').value = '0' + (parseInt(document.getElementById('e-cont-val2-min').value) - 1); }
                    else if(parseInt(document.getElementById('e-cont-val2-min').value) >= 9){ document.getElementById('e-cont-val2-min').value = (parseInt(document.getElementById('e-cont-val2-min').value) - 1); }
				}
			}
		    else if(s == '+')
			{
			    if(parseInt(document.getElementById('e-cont-val2-min').value) == 59)
				{
				    document.getElementById('e-cont-val2-min').value = '00';
				    if(parseInt(document.getElementById('e-cont-val2-hrs').value) < 9){ document.getElementById('e-cont-val2-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val2-hrs').value) + 1); }
                    else if(parseInt(document.getElementById('e-cont-val2-hrs').value) >= 9 && parseInt(document.getElementById('e-cont-val2-hrs').value) < 23){ document.getElementById('e-cont-val2-hrs').value = (parseInt(document.getElementById('e-cont-val2-hrs').value) + 1); }
				    else if(parseInt(document.getElementById('e-cont-val2-hrs').value) == 23){ document.getElementById('e-cont-val2-hrs').value = '00'; }
				}
				else 
				{
				    if(parseInt(document.getElementById('e-cont-val2-min').value) < 9){ document.getElementById('e-cont-val2-min').value = '0' + (parseInt(document.getElementById('e-cont-val2-min').value) + 1); }
                    else if(parseInt(document.getElementById('e-cont-val2-min').value) >= 9){ document.getElementById('e-cont-val2-min').value = (parseInt(document.getElementById('e-cont-val2-min').value) + 1); }
				}
			}
		}*/
        if(e == 1)
		{
		    if(s == '-')
			{
			    if(parseInt(document.getElementById('e-cont-val1-hrs').value) == 0){ document.getElementById('e-cont-val1-hrs').value = '00'; }
				else if(parseInt(document.getElementById('e-cont-val1-hrs').value) > 0)
				{
				    if(parseInt(document.getElementById('e-cont-val1-hrs').value) <= 10){ document.getElementById('e-cont-val1-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val1-hrs').value) - 1); }
                    else if(parseInt(document.getElementById('e-cont-val1-hrs').value) >= 11){ document.getElementById('e-cont-val1-hrs').value = (parseInt(document.getElementById('e-cont-val1-hrs').value) - 1); }
				}
			}
		    else if(s == '+')
			{
			    if(parseInt(document.getElementById('e-cont-val1-hrs').value) == 23){ document.getElementById('e-cont-val1-hrs').value = '00'; }
				else 
				{
				    if(parseInt(document.getElementById('e-cont-val1-hrs').value) < 9){ document.getElementById('e-cont-val1-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val1-hrs').value) + 1); }
                    else if(parseInt(document.getElementById('e-cont-val1-hrs').value) >= 9){ document.getElementById('e-cont-val1-hrs').value = (parseInt(document.getElementById('e-cont-val1-hrs').value) + 1); }
				}
			}
		}
	    else if(e == 2)
		{
		    if(s == '-')
			{
			    if(parseInt(document.getElementById('e-cont-val2-hrs').value) == 0){ document.getElementById('e-cont-val2-hrs').value = '00'; }
				else if(parseInt(document.getElementById('e-cont-val2-hrs').value) > 0)
				{
				    if(parseInt(document.getElementById('e-cont-val2-hrs').value) <= 10){ document.getElementById('e-cont-val2-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val2-hrs').value) - 1); }
                    else if(parseInt(document.getElementById('e-cont-val2-hrs').value) >= 11){ document.getElementById('e-cont-val2-hrs').value = (parseInt(document.getElementById('e-cont-val2-hrs').value) - 1); }
				}
			}
		    else if(s == '+')
			{
			    if(parseInt(document.getElementById('e-cont-val2-hrs').value) == 23){ document.getElementById('e-cont-val2-hrs').value = '00'; }
				else 
				{
				    if(parseInt(document.getElementById('e-cont-val2-hrs').value) < 9){ document.getElementById('e-cont-val2-hrs').value = '0' + (parseInt(document.getElementById('e-cont-val2-hrs').value) + 1); }
                    else if(parseInt(document.getElementById('e-cont-val2-hrs').value) >= 9){ document.getElementById('e-cont-val2-hrs').value = (parseInt(document.getElementById('e-cont-val2-hrs').value) + 1); }
				}
			}
		}
	}
	function setDAY(e)
	{
	    e = 'e-cont-comb' + e;
	    if(document.getElementById(e).style.backgroundColor == "rgb(1, 142, 232)"){ document.getElementById(e).style.backgroundColor = "rgb(244, 67, 54)"; }
		else if(document.getElementById(e).style.backgroundColor == "rgb(244, 67, 54)"){ document.getElementById(e).style.backgroundColor = "rgb(1, 142, 232)"; }
	}
	function Save()
	{
	    var html = '';
		var _days = '';
		var _eqls = '0';
		for(var k = 0;k < 7;k++){ if(document.getElementById('e-cont-comb' + (k + 1)).style.backgroundColor == 'rgb(244, 67, 54)'){ _days += document.getElementById('e-cont-comb' + (k + 1)).innerHTML + '|'; } }
		if(_days != ''){ _days = _days.substring(0 , _days.length - 1); }
		var _hrss = '';
		if(parseInt(document.getElementById('e-cont-val1-hrs').value) < parseInt(document.getElementById('e-cont-val2-hrs').value)){ _hrss += document.getElementById('e-cont-val1-hrs').value + ':' + document.getElementById('e-cont-val1-min').value + '|' + document.getElementById('e-cont-val2-hrs').value + ':' + document.getElementById('e-cont-val2-min').value; }
	    else if(parseInt(document.getElementById('e-cont-val1-hrs').value) == parseInt(document.getElementById('e-cont-val2-hrs').value)){ if(parseInt(document.getElementById('e-cont-val1-min').value) < parseInt(document.getElementById('e-cont-val2-min').value)){ _hrss += document.getElementById('e-cont-val1-hrs').value + ':' + document.getElementById('e-cont-val1-min').value + '|' + document.getElementById('e-cont-val2-hrs').value + ':' + document.getElementById('e-cont-val2-min').value; } }
 		if(_days != '' && _hrss != '')
		{
			$.ajax({
				url: 'settings.php',
				type: 'GET',
				dataType: 'json',
				cache: false,
				data:
				{
					ip:'0.0.0.0',
					days: _days,
					hours: _hrss
				},
				contentType: false,
				timeout: 8000,
				success: function(a){ _eqls = a; },
				error: function (request, status, error){ console.log(request.responseText); }
			});
		}
		if(_days == ''){ console.log("SELECIONE OS DIAS DA SEMANA!"); }
		if(_hrss == ''){ console.log("SELECIONE O HORARIO CORRETO!"); }
		if(_hrss != '' && _days != '')
		{
			$.ajax({
				url: 'settings.php',
				type: 'GET',
				dataType: 'json',
				cache: false,
				data:
				{
					ip:'0.0.0.0',
					info: 'TIMERS',
				    eqls: _eqls
				},
				contentType: false,
				timeout: 8000,
				success: function(a){ $(".e-cont-dates").html('');for(var k = 0;k < a.length;k++){ $(".e-cont-dates").append(a[k]); } },
				error: function (request, status, error){ console.log(request.responseText); }
			});
		}
	}
    </script>
</head>
<body>
    <div class="e-back"></div>
    <div id="e-cont-dates" class="e-cont-dates"></div>
	<input type="image" src="../img/2099190.png" onclick="RET()" class="e-ret-ie"/>
</body>
</html>
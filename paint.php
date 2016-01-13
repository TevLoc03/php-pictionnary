<?php session_start();

if (!isset($_SESSION['user'])) {
    header("Location: main.php");
}

?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset=utf-8 />
        <title>Pictionnary</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <style type="text/css">
        body.design{
                background: #EEEBDA url('img/bg.png');
                background-size: cover;
                background-position: center;
            }
        </style>
        <script type="text/javascript">
			var sizes = [8, 20, 44, 90];
			var size, color;
			var commands = [];
	
			var setColor = function() {
				color = document.getElementById('color').value;
			};
	
			var setSize = function() {
				size = sizes[document.getElementById('size').value];
			};
	
			window.onload = function() {
				var canvas    = document.getElementById('myCanvas');
				canvas.width  = 300;
				canvas.height = 400;
				var context   = canvas.getContext('2d');
	
				canvas.style.marginLeft = ((window.innerWidth - canvas.width) / 2) + "px";
	
				window.onresize = function() {
					canvas.style.marginLeft = ((window.innerWidth - canvas.width) / 2) + "px";
				};
	
				setSize();
				setColor();
	
				document.getElementById('size').onchange  = setSize;
				document.getElementById('color').onchange = setColor;
	
				var isDrawing = false;
	
				var startDrawing = function(e) {
					isDrawing = true;
				};
	
				var stopDrawing = function(e) {
					isDrawing = false;
				};
	
				var draw = function(e) {
					if (isDrawing) {
						commands.push({
							command : "draw",
							x : e.x - this.offsetLeft,
							y : e.y - this.offsetTop,
							size: size / 2,
							color: color
						});
	
						context.beginPath();
						context.fillStyle = color;
						context.arc(e.x - this.offsetLeft, e.y - this.offsetTop, size / 2, 0, 2 * Math.PI);
						context.fill();
						context.closePath();
					}
				};
	
				canvas.onmousedown = startDrawing;
				canvas.onmouseout  = stopDrawing;
				canvas.onmouseup   = stopDrawing;
				canvas.onmousemove = draw;
	
				document.getElementById('restart').onclick = function() {
					commands.push({
						command : "clear"
					});
	
					context.clearRect(0, 0, canvas.width, canvas.height);
				};
	
				document.getElementById('validate').onclick = function() {
					document.getElementById('commands').value = JSON.stringify(commands);
					document.getElementById('picture').value = canvas.toDataURL();
				};
	
				$("#my-tools").draggable();
			};
    	</script>
	</head>
	<body class="design">
    <div class="container">
		<canvas style="border:1px solid black;background: white;" id="myCanvas"></canvas>
    <div class="panel panel-default col-md-12" id="my-tools">
    	<div class="panel-body">
        	<form name="tools" action="req_paint.php" method="post" class="form-horizontal">
            
            	<div class="form-group">
                	<label class="col-md-3 control-label" for="size">Taille:<span id="taille">0</span></label>
                	<div class="col-md-9">
                    	<input class="input-md" type="range" id="size" min="0" max="3" step="1" value="0" oninput="document.getElementById('taille').textContent=value"/>
                	</div>
            	</div>

            	<div class="form-group">
                	<label class="col-md-3 control-label" for="color">Couleur:</label>
                	<div class="col-md-9">
                    	<input class="form-control input-md" type="color" id="color" value="#000000" onchange=""/>
                	</div>
           	 	</div>
            	<div class="form-group">
                	<label class="col-md-3 control-label" for="nom_dessin">Nom:</label>
                	<div class="col-md-9">
                   	 	<input class="form-control input-md" type="text" id="nom_dessin" name="nom_dessin" />
                	</div>
           	 	</div>
            <br />

            <div class="form-group text-center">

                <a class="btn btn-danger" href="main.php">Retour</a>
                <input class="btn btn-primary" id="restart" type="button" value="Recommencer"/>
                <input type="hidden" id="commands" name="commands"/>
                <input type="hidden" id="picture" name="picture"/>
                <input class="btn btn-success" id="validate" type="submit" value="Valider"/>
           
            </div>
        </form>
    </div>
</div>
</div>
</body>
</html>
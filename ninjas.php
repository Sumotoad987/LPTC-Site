
<!DOCTYPE html>
<html>
<head>
	<title>Ninjas</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="https://cdn.jsdelivr.net/jquery.sidr/2.2.1/stylesheets/jquery.sidr.dark.min.css" rel="Stylesheet" />
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="js/jquery.lettering.js"></script>
	<!-- Custom Theme files -->
	<!--theme-style-->
	<link href="css/style.css?v=0.11" rel="stylesheet" type="text/css" media="all" />	
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<!--//theme-style-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Scientist Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<script>
		//Gets parameters from a url
		function getQueryParams(qs) {
			qs = qs.split('+').join(' ');

			var params = {},
				tokens,
				re = /[?&]?([^=]+)=([^&]*)/g;

			while (tokens = re.exec(qs)) {
				params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
			}

			return params;
		}
		function setupLists(){
			$("#Ninjas").css("left", 0);
			$("")
			//Make them into lists
			$("d a").each(function(){
				$(this).wrap("<li></li>")
		  	});
		 	$("c a").each(function(){
				$(this).wrap("<li></li>")
		 	});
		  	$("d").wrapInner("<ul></ul>");
		 	$("c").wrapInner("<ul></ul>");
		 	//Wrap c in a div to make it go to the right
		 	$("#c").addClass("col-md-6")
		 	$("<h3 style='display:inline-block'>Scratch Ninjas</h3>").insertBefore("c");
		 	//Give a header to the d
		 	$("<h3>HTML Ninjas</h3>").insertBefore("d");
		 	$("d").css("display", "inline-block");
		    $("#d").addClass("col-md-6");
		 }
		function getRotationDegrees(obj) {
			var matrix = obj.css("-webkit-transform") ||
			obj.css("-moz-transform")    ||
			obj.css("-ms-transform")     ||
			obj.css("-o-transform")      ||
			obj.css("transform");
			if(matrix !== 'none') {
				 var values = matrix.split('(')[1].split(')')[0].split(',');
				 var a = values[0];
				 var b = values[1];
				 var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
			}else{
				 var angle = 0;
			}
			return (angle < 0) ? angle + 360 : angle;
		}
		function addLinks(element){
			object = $(element);
			for(var e = 0; e < object.children().length; e++){
				for(var i = 0; i < object.children()[e].childNodes.length; i++){
					child = object.children()[e].childNodes[i];         		
					parent = document.createElement("a"); 
					parent.href=object.children()[e].href; 
					console.log(object.children()[e].href);
					parent.setAttribute("class", "circleLink")
					parent.setAttribute("style", "width: " + width + "px");        		
					child.insertBefore(parent, child.childNodes[0]); 
					parent.appendChild(child.childNodes[1]);
				}
				object.children()[e].href="";
			}
		}
		var width = 0;
		function setupRotation(element, height){
			$(element + " a").lettering();
			var totalChars = $(element + " span").length;
			var degreesPerChar = 360 / totalChars; 
			width = degreesPerChar * 2;         
			var currentOffset = 0;
			 // Apply-->
			$(element + " span").each(function(){          
				$(this).css('-webkit-transform', 'rotate('+currentOffset+'deg)');            
				height = (2.6890756303 * $(element + " span").length > 700) ? 2.6890756303 * $(element + "span").length : height;
				$(this).css('padding-bottom', height);
				currentOffset += degreesPerChar;
			});
		}
		function beginRotation(){
			 var id = window.setInterval(function(){
				letters = ['c','d']
				for(i = 0; i < 2; i++){
					$(letters[i] + " span").each(function(){
						var rotation = getRotationDegrees($(this)) + 0.6;
						$(this).css("transform","rotate("+rotation+"deg)");
					});
				}
			}, 100);
			return id;
		}
		$(document).ready(function(){
			$("d a span, c a span").hover(function(){
				console.log(intervalId);
				clearInterval(intervalId);
			}, function(){
				intervalId = beginRotation();
			});
			params = getQueryParams(document.location.search);
			if(window.innerWidth > 750){
				$(function() {
					if(params.list == 'true'){
						setupLists();
						$("#switchFrom").attr("href", 'Ninjas.php?list=false');
					}else{
						setupRotation("d", 360);
						setupRotation("c", 200);
						addLinks("c");
						addLinks("d");
					}
				});
				var intervalId = beginRotation();
			}else{
				setupLists();
				$("#switchFrom").css('display', 'none');
			}
		});
	</script>
    <?php
   		include_once('includes/dbconnect.php');
   		$sql = 'Select Header From Settings';
   		$result = $connection->query($sql);
    	if($result->num_rows > 0){
    		$row = $result->fetch_assoc();
    		echo($row['Header']);
   		 }
	?>
</head>
<body>
<!--header-->
    <div id="header" class="purple" style="width:100%">
        <div class="container-fluid">
            <a href="index.html"><img src="images/coderdojo.png" class="coderdojo"></a>
            <div class="top-nav container-fluid">
				<span class="menu"><img src="images/menu.png" alt=""> </span>
				<div class="collapse navbar-collapse" id="myNavbar">
					<?php
						include('Content/siteNavigation.php');
					?>		
				</div>		
			</div>
			
            <div class="clearfix"> </div>
        </div>
        <script src="https://cdn.jsdelivr.net/jquery.sidr/2.2.1/jquery.sidr.min.js"></script>
		<script>
			$(document).ready(function (){
				$('.menu').sidr({
					name: 'respNav',
					source: '.navbar-collapse',
					side: 'right'
				});			
			});
			$(document).bind("click", function(){
				$.sidr('close', 'respNav');
			});
		</script>
    </div>
<div class="content">
	<a href="Ninjas.php?list=true" id='switchFrom'><i class="fa fa-list pull-right" style="margin-top:3px;"></i></a>
	<div class="container">
        <div id="Ninjas" class="row">
        	<div id="d">
				<d>
					<?php
						function is_dir_empty($dir) {
						  if (!is_readable($dir)) return NULL; 
						  $handle = opendir($dir);
						  while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != "..") {
							  return FALSE;
							}
						  }
						  return TRUE;
						}
						$column = 1;
						$other = "";
						$files = scandir("ninjas/");
						for($number = 0; $number != count($files); $number++){
							if((($number - 3) / $column) == 4){
								$column = $column + 1;
								$other = "reset";
							}
							if( !in_array($files[$number], array("..", ".", ".DS_Store", "index.php"), true)){
								if(!is_dir_empty("ninjas/" . $files[$number])){
									echo("<a href='ninjas/". $files[$number] . "'>" . $files[$number] . " </a>");
									$other = "";
								}
							}
						}
					 ?>
				</d>
        	</div>
        	<div id="c">
				<c>
					<a href="scratch-projects.php?ninja_username=noahwin">crazymue2</a>
					<a href="scratch-projects.php?ninja_username=kyla_errity">Kyla Errity </a>
				</c>
            </div>
        </div>
	</div>
	<div class="content-right">
		<div class="col-md content-right-top">
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<div class="footer">
	<div class="container">
		<div class="col-md-4 footer-top">
			<h3><a href="http://www.coderdojo.com">coderdojo</a></h3>
		</div>
		<div class="col-md-4 footer-top1">
			<ul class="social">
				<li><a href="https://www.facebook.com/Coderdojo-Leixlip-216306561898011/?fref=ts"><i class="facebook"> </i></a></li>
				<li><a href="https://twitter.com/LPTCDojo"><i class="twitter"></i></a></li>
			</ul>
		</div>
		<div class="col-md-4 footer-top2">
			<p >© 2015 - 2017. All rights reserved | Designed and developed by <a href="http://rianscode.com/" target="_blank">Rían Errity</a> | Developed by <a href="http://beattbots.com/" target="_blank">Richard Beattie</a>. All Images are used under the "fair usage policy under the copyright act."</p>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
</body>
</html>

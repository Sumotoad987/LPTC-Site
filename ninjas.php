<!DOCTYPE html>
<html>
<head>
<title>Ninjas</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.lettering.js"></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href="css/style.css?v=1.1" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Scientist Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script>
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
    if(window.innerWidth > 750){
    	$(function() {
        	setupRotation("d", 360);
        	setupRotation("c", 200);
        	addLinks("c");
        	addLinks("d");
        });
        window.setInterval(function(){
            letters = ['c','d']
            for(i = 0; i < 2; i++){
            	$(letters[i] + " span").each(function(){
                	var rotation = getRotationDegrees($(this)) + 0.6;
                	$(this).css("transform","rotate("+rotation+"deg)");
            	});
            }
        }, 100);
    }else{
        $(function() {
          $("d a").each(function(){
            $(this).wrap("<li></li>")
          });
          $("d").wrapInner("<ul></ul>");
        });
    }
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
             <div class="container">
             <a href="index.html"><img src="images/coderdojo.png" class="coderdojo"></a>
             <div class="top-nav">
             <?php
             	include('Content/siteNavigation.php');
             ?>
             <script>
             $("span.menu").click(function(){
                                  $(".top-nav ul").slideToggle(500, function(){
                                                               });
                                  });
             </script>
             </div>
             <div class="clearfix"> </div>
             </div>
             </div>
<div class="content">
	<div class="container">
        <div class="ProjectOfWeek">
             <d>
            <?php
                $column = 1;
                $other = "";
                $files = scandir("ninjas/");
                for($number = 0; $number != count($files); $number++){
                    if((($number - 3) / $column) == 4){
                        $column = $column + 1;
                        $other = "reset";
                    }
                    if( !in_array($files[$number], array("..", ".", ".DS_Store", "index.php"), true)){
                        echo("<a href='ninjas/". $files[$number] . "'>" . $files[$number] . " </a>");
                        $other = "";
                    }
                }
             ?>
             </d>
             <c>
                <a href="scratch-projects.php?ninja_username=noahwin">crazymue2</a>
                <a href="scratch-projects.php?ninja_username=kyla_errity">Kyla Errity </a>
             </c>
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
			<p >© 2015 - 2016. All rights reserved | Designed and developed by <a href="http://rianscode.com/" target="_blank">Rían Errity</a> | Developed by <a href="http://beattbots.com/" target="_blank">Richard Beattie</a>. All Images are used under the "fair usage policy under the copyright act."</p>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
</body>
</html>

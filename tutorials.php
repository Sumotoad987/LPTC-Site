<!DOCTYPE html>
<html>
	<head>
		<title>Tutorials</title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.lettering.js"></script>
		<!-- Custom Theme files -->
		<!--theme-style-->
		<link href="css/style.css?v=1.3" rel="stylesheet" type="text/css" media="all" />	
		<!--//theme-style-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Scientist Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
		Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
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
				<div class="row tutorials-container">
					<h3 style="text-align:center;">Scratch</h3>
					<div class="tutorial col-md-4">
						<img src="images/tutorial-scratch-shoot-the-ball.png" class="tutorial-type-tumbnail">
						<!-- Allows for this entire div to be a clickable link -->
						<figcaption><a href="tutorial-scratch-shoot-the-balls.php">Shoot the balls<span></span</a><figcaption>		
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
					<p >© 2015 - 2016. All rights reserved | Designed and developed by <a href="http://rianscode.com/" target="_blank">Rían Errity</a> | Developed by <a href="http://beattbots.com/" target="_blank">Richard Beattie</a>. All Images are used under the "fair usage policy under the copyright act."</p>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</body>
</html>

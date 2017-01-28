<!DOCTYPE html>
<html>
<head>
<title>LPTCDojo | Be cool</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<script src="js/quotes.js"></script>
<script>
	//Anylitcs
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-86397592-1', 'auto');
  ga('send', 'pageview');
  
  setupQuotes("js/quotes.json");
</script>
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
	window.onload = updateCal;
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
    "Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ];
	function updateCal(){
		url = "https://www.googleapis.com/calendar/v3/calendars/lofjdpkf8618f8ussbovmjkehc@group.calendar.google.com/events?key=AIzaSyACXx9RDMoj8hYQWEM2OhVyhPKHuT21y3I"
		$.getJSON(url, function(data) {
			var first = true;
            for(var i = 0; i < data["items"].length; i++){
                eventStarts = new Date(data["items"][i]["start"]["dateTime"].split("T")[0]);
             	var date = new Date()
             	if(eventStarts > date){
             		month = months[eventStarts.getMonth()];
             		date = eventStarts.getDate();
             		info = data["items"][i].description
             		if(first == true){
             			document.getElementById("date").innerHTML = date + "<small>" + month + "</small>";
             			document.getElementById("info").innerHTML = info;
             			first = false;
             		}else{
             			entry = $(".entry").clone();
             			dateElement = entry.find("span");
             			dateElement.html(date + "<small class='dateSmall'>" + month + "</small>");
             			dateElement.attr("class", "dateSmall");
             			infoElement = entry.find("p");
             			infoElement.html(info);
             			$(".content-bottom-top").append(entry);
             		}
             	} 
            }
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
<div class="header">
	<div class="container">
        <div class="logo">
            <h1><a href="index.html"></a></h1>
        </div>
		<div class="top-nav">
			<span class="menu"><img src="images/menu.png" alt=""> </span>
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
<!---->
</div>
<div class="content">
	<div class="container">
		<!--content-top-->
		<div class="content-top">
			<div class="content-top1">
				<div class=" col-md-4 grid-top">
					<div class="top-grid">
					 <i class="glyphicon glyphicon-edit "></i>
					  <div class="caption">
						<h3>What is Coderdojo</h3>
						<p>Coderdojo is a programming club for those aged 7 to 17 that was founded in July, 2011 by James Whelton and Bill Liao</p>
					  </div>
					</div>
				</div>
			  	<div class=" col-md-4 grid-top">
					<div class="top-grid">
					 <i class="glyphicon glyphicon-book"></i>
					  <div class="caption">
						<h3>Educational</h3>
						<p>Learning to program has been proved to be beneficial in the workplace.</p>
					 </div>
				</div>
				</div>
				<div class=" col-md-4 grid-top">
					<div class="top-grid">
					 <i class="glyphicon glyphicon-time"></i>
					  <div class="caption">
						<h3>It is fun</h3>
						<p>Coderdojo isn't like school, it is a friendly envoirment where kids teach kids and learn to do things that excite them</p>
					  </div>
					</div>
				</div>
			<div class="clearfix"> </div>
		</div>
		</div>
		<!--//content-top-->
		<!--cpntent-mid-->
		<div class="content-middle">
			<div class="row">
			<div class="col-md-7 content-mid">
				<a href="single.html"><img class="img-responsive" src="images/md.jpg" alt=""></a>
			</div>
			<div class="col-md-5 content-mid1">
				<i class="glyphicon glyphicon-filter"> </i>
				<h2>With a focus on peer to peer learning</h2>
				<p>our dojo emphasizes projects more than following mentors tutorials, students are encouraged to have projects which the mentors and their fellow peers help them with through out the sessions, this allows students to become better at troubleshooting but also allows them to pursue what they are interested in.</p>
				<a href="single.html"><i class="glyphicon glyphicon-circle-arrow-right"> </i></a>
			</div>
			</div>
			<div class="clearfix"> </div>
			<div class="row" id="dojo-info">
				<div class="col-md-6">
					<p>The LPTCDojo is on (nearly) every Saturday from 1pm to 3pm in Hewlett-Packard, Lexlip and it is FREE! So why not come along.</p>
					<br>
					<p>We have tables for teaching Scratch and Web developement, and some other ninjas work with Swift, Java, C#, Python, Lua and a bunch of other languages so a lot can be thought to the Ninjas that attend.</p>
					<br>
					<p>Please bring:</p>
					<ul style="padding-left:40px;">
						<li>A snack if needed</li>
						<li>A laptop</li>
						<li>A parent or guardian if you are under 12</li>
					</ul>
				</div>
				<div class="col-md-6">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2381.3859564742284!2d-6.514396948981207!3d53.35424728172277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48677190075bd537%3A0x19c1e4d2ab9cd016!2sHewlett-Packard!5e0!3m2!1sen!2sie!4v1477676294849" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<!--//content-mid-->
		<!--content-left-->
	</div>
	<div class="content-right">
		<div class="col-md content-right-top">
			<p id="Quote" class="quotes"></p>
			<p id="Source" class="quotes"></p>
		</div>
		<div class="clearfix"> </div>
	</div>
	<div class="content-bottom">
        <div class="container content-bottom-top" style="text-align:center">
			<h4>Upcoming Events</h4>
			<div class="entry">
            	<div style="float:left;position:absolute;">
                	<span id="date">16<small>Jan</small></span>
            	</div>
            	<div>
            		<p id="info">Coderdojo Returns after the Christmas Holidays!</p>
        		</div>
        		<div class="clearfix"> </div>
        	</div>
		</div>
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

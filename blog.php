<html>
<head>
    <title>Blog</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Merriweather:400,300,600,700,800">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <link href="css/style.css?v=1.2" rel="stylesheet" type="text/css" media="all" />
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Scientist Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
        Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script>
        var loaded = 3;
        var posts = [];
        window.onload = hidePosts;
        function hidePosts(){
            console.log(loaded)
            posts = document.getElementsByClassName("post");
            for(var i = 0; i < posts.length; i++){
                if(i > loaded){
                    console.log(i);
                    posts[i].style.display = 'none';
                }else{
                    posts[i].style.display = 'block';
                }
            }
            if(loaded => post.length){
               document.getElementById("loadMore").style.display="none";
            }
        }
        function loadMore(){
            console.log("debug");
            loaded = loaded + 4;
            hidePosts();
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
<body style="font-color:white;">
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
    <style>
    ul{
    	list-style-position: inside;
    }
    </style>
    <div class="container blog-content">
        <div class="row">
            <div class="col-lg-8">
                <?php
                	require_once("includes/dbconnect.php");
                	$sql = "SELECT Name, content, UserId, Modified from Posts";
                	$results = $connection->query($sql);
                	$stmt = $connection->prepare("Select Username From Users Where id = ?");
                	if($results->num_rows > 0){
                		while($row = $results->fetch_assoc()){
                			$times = explode(" ", $row['Modified']);
                			$stmt->bind_param("i", $row['UserId']);
                			$stmt->execute();
                			$stmt->bind_result($username);
                			$stmt->fetch();
                			echo("<div class='post'><h2>" . $row['Name'] . "</h2><hr class='titleHr'>" . '<div class="postText">' . $row['content'] . '</div>' . '<br><p class="postInfo"><i class="fa fa-user"></i> ' . $username . '</p> <p class="postInfo"><i class="fa fa-clock-o"></i> ' . $times[0] . '</p><hr>');
                			$tags = explode(", ", $row['Tags']);
                			for($i = 0; $i < count($tags) - 1; $i++){
                				echo('<div class="topic"><a>' . $tags[$i] . '</a></div>');
                			}
                			echo("</div>");
                		}
                	}
                ?>
                <br>
                <a onclick="loadMore()" id="loadMore" style="margin-bottom:15px;">Load more</a>
            </div>
            <!-- 
<div class="col-md-3 sidebar" style="color:white">
                <div class="center text-center">
                    <h2>Newsletter</h2>
                    <p>Subscribe to our email list</p>
                <?php
                    if(isset($_POST['email'])){
                       $stmt = $connection->prepare("INSERT IGNORE INTO Emails (Email) VALUES (?)");
                       $stmt->bind_param("s", $_POST['email']);
                       $stmt->execute();
                    }
                ?>
                    <form action="blog.php" method="post" role="form">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input class="form-control" type="text" id="" name="email" placeholder="your@email.com">
                        </div>
                        <br>
                        <input type="submit" value="Subscribe" class="btn btn-large" />
                    </form>
                </div>
            </div>
 -->
        </div>
    </div>
    <div class="content-right" style="margin-top:15px;">
        <div class="col-md content-right-top">
        </div>
        <div class="clearfix"> </div>
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

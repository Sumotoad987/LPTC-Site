<!DOCTYPE html>
<html>
  <head>
    <title>LPTCDojo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">   
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Merriweather">
    <link href="https://cdn.jsdelivr.net/jquery.sidr/2.2.1/stylesheets/jquery.sidr.dark.min.css" rel="Stylesheet" />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
    * { box-sizing: border-box; }
      .project {
        /*background-color: #00bce4;
        border: 1px solid black;*/
        margin: 5px;
        justify-content: space-between;
        /* overflow: auto; */
        display:         flex;
  		flex-wrap: wrap;
      }
      .project-details {
        order: 1;
        /* overflow: auto; */
        border: 1px solid black;
        box-shadow: 0 5px 5px 0 rgba(0,0,0,0.14),0 5px 2px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
      }
      .project-scene {
        order: 1;
        float: left;
      }

      .project-scene img, .project-player {
        height: 100%;
        width: 100%;
        /*margin: auto;*/
      }

      .project-scene img {
        display: block;
      }
      .project-player {
        display: none; /** Do not show iframe on load */
      }
      .intrinsic-container{
      	position:relative;
      	height:0;
      	overflow:hidden;	
      	padding-bottom:82.88%;
      }
    .intrinsic-container iframe {
	  position: absolute;
	  top:0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	}
	.intrinsic-container img {
	  position: absolute;
	  top:0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	}
	.row > [class*='col-'] {
  		display: flex;
 		 flex-direction: column;
	}
    </style>
  </head>
<body>
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
  <div class="container">
  <!-- Listing of Ninjas Scratch projects -->
  <?php
    require_once('includes/api/scratch.php');

    function displayProject($project) {
      echo '<div class="project row" id="' . $project["id"] . '">';
      echo '<div class="project-details col-xs-6 content-mid1">';
      echo '<div><h3>Title</h3><p>' . $project["title"] . '</p></div>';

      if (!empty($project["description"]) ) {
        echo '<div><h3>Description</h3><p>' . $project["description"] . '</p></div>';
      }
      if (!empty($project["instructions"])) {
        echo '<div><h3>Instructions</h3><p>' . $project["instructions"] . '</p></div>';
      }

      echo '<div><h3>Views</h3><p>' . $project["stats"]["views"] . '</p></div>';
      echo '<div><a href="#' . $project["id"] . '">Permalink</a></div>';
      echo '</div>';
      echo '<div class="project-scene col-xs-6" >';
      echo '<div class="intrinsic-container">';
    echo '<img data-project_id="' . $project["id"]. '" src="' . $project["image"] . '" />';
      echo '<iframe class="project-player" frameborder="0"></iframe>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }

    function displayProjects($scratchUser) {
      if(!empty($scratchUser)) {
        // Make the request to the Scratch API to retrieve the Ninjas projects.
        $projects = ScratchProjects::getUserShared($scratchUser);

        if(!isset($projects['HttpCode']) && $projects['HttpCode'] === 404) {
          echo '<p>Provided Scratch username not found</p>';
          return;
        }
        // Loop through each projects and display its information.
        foreach($projects as $i => $project) {
          displayProject($project);
        }
      }
    }

    $scratchUser = filter_input(INPUT_GET, 'ninja_username', FILTER_SANITIZE_STRING);
    displayProjects($scratchUser);
  ?>
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
  <script type="text/javascript">
  	var hasFlash = false;
	try {
		hasFlash = Boolean(new ActiveXObject('ShockwaveFlash.ShockwaveFlash'));
	} catch(exception) {
		hasFlash = ('undefined' != typeof navigator.mimeTypes['application/x-shockwave-flash']);
	}
	if(hasFlash == true){
		$(".project-scene img").on("click", function() {
		  var projectId = $(this).data("project_id");
		  var playerUrl = "https://scratch.mit.edu/projects/embed/" + projectId + "/";
		  var playerIframe = $(this).next()
		  $(this).css("display", "none");
		  playerIframe.attr("src", playerUrl);
		  playerIframe.css("display", "block");
		});
    }
  </script>
</body>
</html>

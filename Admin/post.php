<?php
    session_start();
    require_once("../includes/dbconnect.php");
    require_once("../includes/permissons.php");
    $p = new Permissons($_SESSION["rank"], $connection);
	if(isset($_GET['id'])){
		require_once("../includes/dbconnect.php");
       	$stmt = $connection->prepare("Select Name, Content, Tags From Posts WHERE id = ?");
       	$stmt->bind_param("i", $_GET['id']);
       	$stmt->execute();
       	$stmt->bind_result($name, $content, $tags);
       	$stmt->fetch(); 
       	$stmt->close();
       	if($name == ""){
       		header("Location: posts.php?denied");
       	}
       	$p->hasPermisson(["Post_Edit"]);
	}else{
		$p->hasPermisson(["Post_Create"]);
	}
?>
<html>
	<head>
		<title>Post</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=1.2" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-tagsinput.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
	    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	    <script src="../js/bootstrap-tagsinput.js"></script>
	    <script src="../js/BeattCMS.js" type='text/javascript'></script>
  		<?php
  			if(isset($tags)){
  				echo("<script> var setTags = '" . $tags . "';</script>");
  			}
  		?>
  		<script>
  		tinymce.init({ selector:'.wysiwyg', plugins:['link autoresize'], menubar: false, statusbar: false, toolbar: ["formatselect fontsizeselect | bold italic underline subscript superscript | alignleft aligncenter alignright | bullist numlist | blockquote link"]});
  		$(document).ready(function(){
  			updateOnChange($('.titleTextArea'), $('#postTitle'), 'Title');
  			if (typeof setTags !== 'undefined') {
  				var indiTags = setTags.split(", ");
  				for(var i = 0; i < indiTags.length; i++){
  					$('#tags').tagsinput('add', indiTags[i]);
  				}	
			}
  		});
  		
  		function copyTags(){		  
  			document.getElementById("tagsHidden").value = $("#tags").tagsinput('items');
  		}
  		function display(){
  			$(".dropdown-tags").toggle();
  			$(".fa-arrow-up").toggle();
  			$(".fa-arrow-down").toggle();
  		}
  		</script>
	</head>
	<body>
		<form onsubmit="copyTags()" action="Actions/post.php" method="POST">
		<div class="wrapper">
		<nav class="nav navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapseable">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand">Homepage</a>				
				</div>
				<div class="collapse navbar-collapse" id="collapseable"> 
					<ul class="nav navbar-nav side-nav">
						<div class="side-nav-header">
							<a href="posts.php"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>
						</div>
						<div id="postInfo">
							<h2 style="color:white" id="postTitle">Title</h2>
							<?php
								$value = isset($_GET['id']) ? 'Update' : "Post";
								echo("<input type='submit' class='btn btn-primary' style='margin-right:5%;' value='{$value}'>");
							?>
							<button class="btn btn-default" style="margin-left:5%;">Preview</button>
						</div>
						<li style="background-color:#cccccc;">
							<a><div onclick="display();">Tags<i style="float:right" class="fa fa-arrow-down fa-1" aria-hidden="true"></i><i style="float:right;display:none;" class="fa fa-arrow-up fa-1" aria-hidden="true"></i></div></a>
							<div class="dropdown-tags">
								<input id="tags" data-role="tagsinput">
								<input id="tagsHidden" name="tags" type="hidden">
							</div>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="glyphicon glyphicon-user"></span> 
								<?php echo($_SESSION["username"]);?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">View account</a></li>
								<li><a href="#">Edit account</a></li>
								<li class="divider"></li>
								<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container-fluid content">
            <div class="row">
                <div class="col-lg-12 editor" style="padding-left:12.5%;padding-right:12.5%;">
                    <textarea class="titleTextArea" name="Title" rows="1" placeholder="Title"><?php if(isset($name)){echo($name);}?></textarea>
                    <textarea class="wysiwyg" name="Content"><?php if(isset($name)){echo($content);}?></textarea>
                	<?php
                		if(isset($_GET['id'])){
                			echo('<input name="id" type="hidden" value="' . $_GET['id'] . '">');
                		}
                	?>
                </div>
            </div>
		</div>
		</div>
		</form>
	</body>
</html>

<?php
    session_start();
    require_once("../includes/dbconnect.php");
    require_once("../includes/permissons.php");
    $p = new Permissons($_SESSION["rank"], $connection);
	if(isset($_POST['id'])){
		require_once("../includes/dbconnect.php");
       	$stmt = $connection->prepare("Select Title, Content, Tags From Posts WHERE id = ?");
       	$id = (int)$_POST['id'];
       	$stmt->bind_param("i", $id);
       	$stmt->execute();
       	$stmt->bind_result($title, $content, $tags);
       	$stmt->fetch(); 
       	$stmt->close();
       	 $p->hasPermisson("Post_Edit");
	}else{
		$p->hasPermisson("Post_Create");
	}
?>
<html>
	<head>
		<title>Post</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../css/custom.css?v=1.2" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-tagsinput.css" rel="stylesheet">
	    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	    <script src="../js/bootstrap-tagsinput.js"></script>
  		<script>tinymce.init({ selector:'.wysiwyg', plugins:['link autoresize'], menubar: false, statusbar: false, toolbar: ["formatselect fontsizeselect | bold italic underline subscript superscript | alignleft aligncenter alignright | bullist numlist | blockquote link"]});</script>
  		<?php
  			echo("<script> var tags = '" . $tags . "';</script>");
  		?>
  		<script>
  		$(document).ready(function(){
  			var indiTags = tags.split(", ")
  			for(var i = 0; i < indiTags.length; i++){
  				$('#tags').tagsinput('add', indiTags[i]);
  			}
  		    function myFunc(){
  		        var input = $(".editorTextArea").val();
  		        if(input == ""){
  		        	$("#postTitle").text("Title");
  		        }else{
  		        	$("#postTitle").text(input);
  		        }
  		    }       
  		    myFunc();
  		
  		    //either this
  		    $('.editorTextArea').keyup(function(){
  		        $('#postTitle').html($(this).val());
  		    });
  		
  		    //or this
  		    $('.editorTextArea').keyup(function(){
  		        myFunc();
  		    });
  		
  		    //and this for good measure
  		    $('.editorTextArea').change(function(){
  		        myFunc(); //or direct assignment $('#txtHere').html($(this).val());
  		    });
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
								$value = "Post";
								if(isset($_POST['id'])){
									$value = "Update";
								}
								echo('<input type="submit" class="btn btn-primary" style="margin-right:5%;" value="' . $value . '">');
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
<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo($_SESSION["username"]);?><span class="caret"></span></a>
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
				<div class="col-lg-12">
					<h1>Posts</h1>
				</div>
			</div>
            <div class="row">
                <div class="col-lg-12 editor" style="padding-left:12.5%;padding-right:12.5%;">
                    <textarea class="editorTextArea" name="Title" rows="1" placeholder="Title"><?php if(isset($title)){echo($title);}?></textarea>
                    <textarea class="wysiwyg" name="Content"><?php if(isset($title)){echo($content);}?></textarea>
                	<?php
                		if(isset($_POST['id'])){
                			echo('<input name="id" type="hidden" value="' . $_POST['id'] . '">');
                		}
                	?>
                </div>
            </div>
		</div>
		</div>
		</form>
        <script>
            $('.toolbar a').click(function(e){
                                  console.log("Hello");
                var command = $(this).data('command');
                if(command == 'createlink'){
                    url = prompt('Enter the link here: ', 'http:\/\/');
                    document.execCommand(command, false, url);
                }
                else document.execCommand(command, false, null);
            });
        </script>
	</body>
</html>

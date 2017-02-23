<?php
    session_start();
    require_once("../includes/dbconnect.php");
    require_once("../includes/permissons.php");
    $p = new Permissons($_SESSION["rank"], $connection);
    if(isset($_GET['id'])){
    	$p->hasPermisson(["Page_Edit"]);
    	$stmt = $connection->prepare("Select Name, Template, Parent, PageOrder From Pages Where id = ?");
    	$stmt->bind_param("i", $_GET['id']);
    	$stmt->execute();
    	$stmt->bind_result($name, $template, $parent, $pageOrder);
    	$stmt->fetch();
    	$stmt->close();
    	//Get the editable html from page
    	$page = file_get_contents("../{$name}.php");
    	if(strpos($page, '<!--//Content-Begin-->') !== false){
    		$page = explode("<!--//Content-Begin-->", $page)[1];
			$page = explode("<!--//Content-End-->", $page)[0];
    	}
    }else{
		$p->hasPermisson(["Page_Create"]);
	}
?>
<html>
	<head>
		<title>Create page</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/custom.css?v=<?= filemtime('../css/custom.css') ?>" rel="stylesheet">
		<link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../css/bootstrap-select.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../js/BeattCMS.js?v=0.1" type="text/javascript"></script>
		<script src="../js/bootstrap-select.js" type="text/javascript"></script>
		<script>
			templateContent = "";
			function html(){
				$("#htmlEditor").show();
				$("#htmlViewer").hide();
				$("#visual").removeClass("selected")
				$("#html").addClass("selected")
			}
			function updateVisual(){
				editor = ace.edit("htmlEditor");
				if(templateContent != ""){
					content = templateContent.replace("{{ content }}", editor.getValue());
				}else{
					content = editor.getValue()
				}
				$("#htmlViewer").html("<iframe src=" +"data:text/html," + encodeURIComponent(content) + "></iframe>");
			}
			function visual(){
				$("#htmlEditor").hide();
				$("#htmlViewer").show();
				updateVisual();
				$("#html").removeClass("selected")
				$("#visual").addClass("selected")
			}
			$(document).ready(function(){
				function getTemplate(template){
					var xhr;
					if(window.XMLHttpRequest){
						xhr = new XMLHttpRequest();
					}else if(window.ActiveXObject){
						xhr = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xhr.onreadystatechange = function(){
						templateContent = xhr.responseText
						updateVisual();
					};
					if(template != "None"){
						xhr.open("GET", '../Content/templates/' + template);
						xhr.send();
					}else{
						templateContent = "";
						updateVisual();
					}
				}
				value = $(".template-option-selected").attr("value");
				getTemplate(value);
				//Update the side title with the user editable title
				updateOnChange($('.titleTextArea'), $("#postTitle"), "Title");
				//END
				$(".template-option").click(function(event){
					options = $(".template-option-selected");
					$(options[0]).removeClass("template-option-selected");
					target = $(event.target)
					target.addClass("template-option-selected");
					getTemplate(target.attr("value"));
				});
				$(".sidebarOption").click(function(){	  
					console.log()		  
  					$(this).parent().parent().find(".innerOptions").toggle();
  					$(this).find(".fa-arrow-up").toggle();
  					$(this).find(".fa-arrow-down").toggle();
				});
  		    });

  			function prepareValues(){
  				selected = $(".template-option-selected")[0];
  				value = $(selected).attr("value")
  				console.log(selected);
  				$("#template").val(value);
  				var editor = ace.edit('htmlEditor');
				var textarea = $('textarea[name="Content"]');
				textarea.val(editor.getSession().getValue());
  			}
		</script>
	</head>
	<body>
		<form onsubmit="prepareValues()" action="Actions/publish.php" method="POST">
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
							<a href="pages.php"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back</a>
						</div>
						<div id="postInfo">
							<h2 style="color:white" id="postTitle">Title</h2>
							<?php
								$value = isset($_GET['id']) ? "Update" : "Publish";
								echo('<input type="submit" class="btn btn-primary" style="margin-right:5%;" value="' . $value . '">');
							?>
						</div>
						<li style="background-color:#cccccc;">
							<a><div class="sidebarOption">Templates<i style="float:right" class="fa fa-arrow-down fa-1" aria-hidden="true"></i><i style="float:right;display:none;" class="fa fa-arrow-up fa-1" aria-hidden="true"></i></div></a>
							<div class="innerOptions">
								<?php
									$sql = "Select Theme From Settings";
									$results = $connection->query($sql);
									$row = $results->fetch_assoc();
									if(isset($template)){
										$default = $template;
									}else{
										$default = $row['Theme'];
									}
									$loc = "../Content/templates/";
									$files = scandir($loc);
									$files[] = "None";
									foreach($files as $file){
										if( !in_array($file, array("..", ".", ".DS_Store", "index.php"), true)){
											$formatted = str_replace([".html", ".php"], "", $file);
											if($formatted == str_replace([".html", ".php"], "", $default)){
												$attr = "template-option-selected";
											}
											echo("<a value='{$file}' class='template-option {$attr}'>{$formatted}</a>");
											$attr = "";
										}
									}
								?>
							</div>
						</li>
						<li style="background-color:#cccccc;">
							<a>
								<div class="sidebarOption">
									Parent
									<i style="float:right" class="fa fa-arrow-down fa-1" aria-hidden="true"></i>
									<i style="float:right;display:none;" class="fa fa-arrow-up fa-1" aria-hidden="true"></i>
								</div>
							</a>
							<div class="innerOptions">
								<select class="selectpicker" name="parent">
									<option value=''>None</option>
									<?php
										$sql = "Select Name, id, Parent From Pages Order by PageOrder";
										$results = $connection->query($sql);
										$children = array();
										while($row = $results->fetch_assoc()){
											$attribute = "";
											if($row['id'] != $_GET['id'] && intval($row['Parent']) != intval($_GET['id']) && in_array($row['Parent'], $children) == FALSE){
												//Dont display page if it is this page, it is a child of this page if has a ancestor which is a child of this page
												$attribute = $row['id'] == $parent ? "selected" : "";
												$attribute .= $row['Parent'] != NULL ? "data-role='{$row['Parent']}'" : '';
												echo("<option name='{$row['id']}' value='{$row['id']}' {$attribute}>{$row['Name']}</option>");
											}elseif(isset($_GET['id']) == false){
												//Display all pages
												echo("<option name='{$row['id']}' value='{$row['id']}' {$attribute}>{$row['Name']}</option>");
											}else{
												echo($row['id']);
												$children[] = $row['id'];
											}
										}
										var_dump($children);
									?>
									<script>
										$(document).ready(function(){
											//Delete pages that don't have their parent
											$("option[data-role]").each(function(i, option){
												parent = $("option[name=" + $(option).attr('data-role') + "]")
												if(parent.length == 0){
													option.remove()
												}
											});
											//Move pages into correct positons
											$('.selectpicker').selectpicker();
											pages = $('a[data-role]');
											//Move them under
											for(i = 0; i < pages.length; i++){
												dataRole = $(pages[i]).attr('data-role');
												if(dataRole != 'null'){
													//Is a child
													parent = $('a[name=' + dataRole + ']')
													if(parent.parent().parent().prop("tagName") != "DIV"){
														parent.parent().wrap("<div type='temporary'></div>");
													}
													temporaryDiv = parent.parent().parent()
													//Check to see if the child has children
													if($(pages[i]).parent().parent().prop("tagName") == "DIV"){
														//Has children we should move temporary div surrounding it
														pageItem = $(pages[i]).parent().parent()
													}else{
														//Doesn't have children
														pageItem = $(pages[i]).parent()
													}
													temporaryDiv.append(pageItem)
													margin = parseInt($(parent).css('margin-left'), 10) + 10; 
													parentsDataRole = parent.attr('data-role')
													marginMultiplier = 1
													while(parentsDataRole != "null"){
														marginMultiplier += 1
														parentsDataRole = $('a[name=' + parentsDataRole + ']').attr('data-role')
													}
													$(pages[i]).css('margin-left', 10 * marginMultiplier + "px");
												}
											}	
											temporaryDivs = $("[type='temporary']")
											temporaryDivs.each(function(i, div){
												$(div.children[0]).unwrap()
											})									
										});
									</script>

								</select>
								<p><b>Order</b></p>
								<input class="form-group" name="order" value="<?php echo($pageOrder); ?>">
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
                	<div class="box">
                		<textarea id="pageTitle" class="titleTextArea" name="Title" rows="1" placeholder="Title"><?php if(isset($name)){echo($name);}?></textarea>
                		<?php
                			if(isset($name)){
                				echo("<input type='hidden' name='old' value='{$name}'>");
                			}
                		?>
                	</div>
        			<div class="toolbar pages-toolbar">
        				<div class="toolbar-item" id="visual" onclick="visual(this)">
        					<a>Visual</a>
        				</div>
        				<div class="toolbar-item selected" id="html" onclick="html(this)">
        					<a onclick="toggleDisplay(this)">HTML</a>
        				</div>
        				<script>
							prepareToolbar();
						</script>
        			</div>
        			<div class="box">
        				<div id="htmlEditor"></div>
        				<textarea style="display: none;" name="Content"><?php echo($page); ?></textarea>
        				<div id="htmlViewer" style="display:none;"></div>
        				<input type="hidden" name="template" id="template">
        				<?php
        					$value = isset($_GET['id']) ? $_GET['id'] : NULL;
        					echo("<input type='hidden' name='id' value='{$value}'>");
        				?>
						<script src="../includes/ace-src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
						<script>
							var editor = ace.edit("htmlEditor");
							editor.setTheme("ace/theme/tommorow");
							editor.getSession().setMode("ace/mode/php");
							value = $("[name=Content]").text();
							editor.session.setValue(value, -1);
						</script>
        			</div>
                </div>
            </div>
		</div>
		</div>
		</form>
	</body>
</html>

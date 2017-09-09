<ul>
    <li><a href="index.php" class="hvr-sweep-to-bottom">Home</a>
    <li><a href="blog.php" class="hvr-sweep-to-bottom">Blog</a></li>
    <li><a href="tutorials.php" class="hvr-sweep-to-bottom">Tutorials</a></li>
    <!-- 
<li class="dropdown">
    	<a href="http://stackoverflow.com/" class="hvr-sweep-to-bottom">Stack Overflow <b class="caret"></b></a>
		<ul class="dropdown-menu-custom">
			<li><a href="/page2">Page2</a></li>
			<li><a href="/page2">Page3</a></li>
		</ul>
	</li>
 -->
	<?php
		require_once("includes/dbconnect.php");
		$sql = 'Select Name, id, Parent From Pages Order by PageOrder';
		$results = $connection->query($sql);
		if($results->num_rows > 0){
			while($row = $results->fetch_assoc()){
				echo("<li value={$row['id']} data-role='{$row['Parent']}'><a href='{$row['Name']}.php' class='hvr-sweep-to-bottom'>{$row['Name']}</a></li>");
			}
		}
	?>
	<script type="text/javascript">
		var path = window.location.pathname;
		var page = path.split("/").pop();
		$('.top-nav li a').each(function (){
			var href = $(this).attr('href');
			if(href === page){
				$(this).closest('li').addClass('active');
			}
		});
		navigationItems = $("li[data-role]");
		for(var i = 0; i < navigationItems.length; i++){
			dataRole = $(navigationItems[i]).attr("data-role")
			if(dataRole != ""){
				//Element is a child
				parent = $("li[value=" + dataRole + "]")
				console.log($(parent).attr("data-role"));
				if($(parent).attr("data-role") == ""){
					//Parent is not a child of something else
					console.log(parent)
					parent.addClass("dropdown")
					if(parent.find("ul.dropdown-menu-custom").length == 0){
						parent.append("<ul class='dropdown-menu-custom'></ul>")
						parent.find("a.hvr-sweep-to-bottom").append('<b class="caret"></b>')
					}
					console.log(parent.find("ul.dropdown-menu-custom"))
					ul = parent.find("ul.dropdown-menu-custom")
					ul.append(navigationItems[i])
					ul.append("<br>")
				}else{
					//Parent is a child of something else
					navigationItems[i].remove()
				}
			}
		}
	</script>
	<div class="clearfix"></div>
</ul>
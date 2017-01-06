<ul>
    <li><a href="index.php" class="hvr-sweep-to-bottom">Home</a>
    <li><a href="blog.php" class="hvr-sweep-to-bottom">Blog</a></li>
	<?php
		require_once("includes/dbconnect.php");
		$sql = 'Select Name From Pages';
		$results = $connection->query($sql);
		if($results->num_rows > 0){
			while($row = $results->fetch_assoc()){
				echo("<li><a href='{$row['Name']}.php' class='hvr-sweep-to-bottom'>{$row['Name']}</a></li>");
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
	</script>
	<div class="clearfix"></div>
</ul>
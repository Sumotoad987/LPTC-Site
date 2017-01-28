<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapseable">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand">Admin panel</a>				
</div>
<div class="collapse navbar-collapse" id="collapseable"> 
	<ul class="nav navbar-nav side-nav">
		<li><a href="index.php">Dashboard</a></li>
		<li><a href="posts.php">Posts</a></li>
		<li class="dropdown">
			<a href="users.php" class="vertical-toggle">Users</a><a class="dropdown-toggle vertical-toggle" data-toggle="dropdown"><span class="caret"></span></a>
			<ul class="dropdown-menu vertical-dropdown" role="menu">
				<li><a href="invite.php">Invite new user</a></li> 
				<li><a href="ranks.php">Ranks</a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="pages.php" class="vertical-toggle">Pages</a><a class="dropdown-toggle vertical-toggle" data-toggle="dropdown"><span class="caret"></span></a>
			<ul class="dropdown-menu vertical-dropdown" role="menu">
				<li><a href="page.php">Create new page</a></li>
			</ul>
		</li>
		<li><a href="addons.php">Addons</a></li>
		<li><a href="settings.php">Settings</a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="glyphicon glyphicon-user"></span> 
				<?php echo($_SESSION["username"]);?>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<?php
					echo("<li><a href='profile.php?id={$_SESSION['id']}'>View account</a></li>")
				?>
				<li class="divider"></li>
				<li><a href="../Content/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</li>
	</ul>
</div>


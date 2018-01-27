<html>
    <head>
        <title>Login</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/font-awesome/css/font-awesome.css" rel="stylesheet">
    </head>
    <body>
        <div class="login-box">
        	<?php
        		if(isset($_GET['denied'])){
					echo("<p class='denied'>Incorrect username or password</p>");
				}
			?>
            <form action="Content/login.php" method="post" role="form">
                <p>Email</p>
                <input class="form-control" type="text" name="email" id="email" placeholder="Email">
                <br>
                <p>Password</p>
                <input class="form-control" type="password" name="password" placeholder="Password">
                <br>
                <input type="submit" class="btn btn-primary login" value="Login">
            </form>
            <a href="index.php"><i class="fa fa-arrow-left fa-1" aria-hidden="true"></i> Back to site</a>
        </div>
        <style>
            body{
                background-color:#eee;
            }
            .login-box{
                width:25%;     
                margin-top:13%;
                margin-left:auto;
                margin-right:auto;
            }
            .login-box form{ 
            	background-color:white;
            	padding:25px;
            	border-radius:5px;
            }
            .login-box a{
            	bottom:20;
            	position:fixed;
            }
            .login-box a:hover{
            	text-decoration:none;
            }
            .login{
                width:100%;
            }
            .login-box p{
            	font-weight:600;
            	font-size:15px;
            }
            .login-box .form-control{
            	margin-bottom:2%;
            	border-radius:2px !important;
            	height:6%;
            	font-size:16px;
            	width:100%;
            }
            .denied{
				color:#ff4d4d;
				animation: fadeinout 4s linear forwards;
				-webkit-animation: fadeinout 4s linear forwards;
			}
			@-webkit-keyframes fadeinout {
			  0%,85% { opacity: 1; }
			  100% { opacity: 0;}
			}

			@keyframes fadeinout {
			  0%,85% { opacity: 1; }
			  100% { opacity: 0;}
			}
        </style>
    </body>
</html>

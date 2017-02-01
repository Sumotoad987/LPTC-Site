<?php
	require_once("includes/dbconnect.php");
	if($_GET['authCode'] == NULL){
		header("Location: ../index.php");
	}
	$stmt=$connection->prepare("Select AuthCode from Users WHERE AuthCode = ?");
	$stmt->bind_param("s", $_GET['authCode']);
	$stmt->execute();
	$stmt->bind_result($authCode);
	$stmt->fetch();
	$stmt->close();
	if($authCode == ""){
		header("Location: index.php");
	}
?>
<html>
    <head>
        <title>Login</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    </head>
    <body>
        <div class="login-box">
            <h3>Setup your account</h3>
            <br>
            <form action="Content/signup.php" method="post" role="form">
                <div class="input-group">
                	<p>Username:</p>
                    <input class="form-control" type="text" name="username" id="email" placeholder="Username">
                    <br>
                    <p>Password:</p>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                    <br>
                    <?php
                    	echo("<input type='hidden' value='" . $authCode . "' name='authCode'>");
                    ?>            
                    <input type="submit" class="btn btn-info signin" value="Complete registration">
                </div>
            </form>
        </div>
        <style>
            body{
                background-color:#eee;
            }
            .login-box{
                width:25%;
                text-align:center;
                background-color:white;
                padding:25px;
                border-radius:5px;
                margin-top:10%;
                margin-left:auto;
                margin-right:auto;
            }
        
            .input-group{
            	margin-left:auto;
            	margin-right:auto;
            }
            .input-group .form-control{
            	margin-bottom:2%;
            	border-radius:2px !important;
            }
        </style>
    </body>
</html>
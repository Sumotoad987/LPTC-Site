<?php
    $hello = "Hello";
    function db_connect() {
        
        // Define connection as a static variable, to avoid connecting more than once
        static $connection;
        
        // Try and connect to the database, if a connection has not been established yet
        if(!isset($connection)) {
            // Load configuration as an array. Use the actual location of your configuration file
            $path = $_SERVER['DOCUMENT_ROOT'];
            // $path = "/hsphere/local/home/jado41/private/config.ini";
           	$path .= '/private/config.ini';
            $config = parse_ini_file($path);
            $connection = mysqli_connect($config['servername'],$config['username'],$config['password'],$config['dbname']);
        }
        // If connection was not successful, handle the error
        if($connection === false) {
        	echo("Not succesful");
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            echo(mysqli_connect_error());
        }
        return $connection;
    }
    
    // Connect to the database
    $connection = db_connect();
    
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    ?>

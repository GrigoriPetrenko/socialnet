<?php
	/* database connection settings */
	$host = 'localhost';
	$user = 'admin';
	$pass = 'qwerty';
	$database = 'socialnet';
	$connect = mysqli_connect($host, $user, $pass, $database)
				or die('Couldn`t connect. Error: <b>'.mysqli_connect_error().'<b>');
	//if($connect) echo 'success';
?>
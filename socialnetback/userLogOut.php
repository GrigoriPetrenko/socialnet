<?php
	//session_id('user');
	session_start();
	require_once('connect.php');
	require_once('formValid.php');
	$data = json_decode(file_get_contents('php://input'));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	//require_once('userId.php');
	$query = "DELETE from users_online WHERE user_session_id = $sessionId";
	$query = mysqli_query($connect,$query);
	session_destroy();
	session_commit();
?>
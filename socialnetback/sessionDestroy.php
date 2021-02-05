<?php
	session_id('user');
	session_start();
	//require_once('userId.php');
	//$query = "DELETE from users_online WHERE user_session_id = $session_id";
	session_destroy();
	session_commit();
?>
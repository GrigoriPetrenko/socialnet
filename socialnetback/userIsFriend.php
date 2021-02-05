<?php
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	
	$user_id = form_validate(mysqli_real_escape_string($connect,$data->userId));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	
	$query = "SELECT * FROM friends 
			  WHERE ((friends.user_id = $sessionId and friends.friend_id = $user_id) or 
			  (friends.friend_id = $sessionId and friends.user_id = $user_id)) and friends.friends_status = 1";
	
	$query = mysqli_query($connect, $query);
	
	if (mysqli_num_rows($query) > 0) {
		echo 1;
	} else {
		echo 0;
	}
	
	mysqli_close($connect);
?>
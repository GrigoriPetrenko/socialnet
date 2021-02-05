<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	$user_id = mysqli_real_escape_string($connect,$data->friendshipID);
	
	$query = "DELETE FROM friends 
			  WHERE (friends.friend_id = $user_id and friends.user_id = $sessionId) 
			  or (friends.user_id = $user_id and friends.friend_id = $sessionId)";
	
	$query = mysqli_query($connect, $query);
	
	if($query) {
		echo "Friend deleted";
	} else {
		echo "Error";
	}
	
	mysqli_close($connect);
?>
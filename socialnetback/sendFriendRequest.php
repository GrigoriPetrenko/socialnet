<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	
	//echo $_SESSION['vlad'];
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$friend_id = mysqli_real_escape_string($connect,$data->friendId);
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));

	if(isset($friend_id)) {
		$query = "SELECT * FROM friends WHERE user_id = $sessionId and friend_id = $friend_id and friends_status = 0";
		$query = mysqli_query($connect, $query);
		if(mysqli_num_rows($query) > 0) echo "The request already has been sent to the user";
		else {
			$query = "INSERT INTO friends (id, user_id, friend_id, friends_status) 
					  VALUES (NULL, $sessionId, $friend_id, 0)";	
			$query = mysqli_query($connect, $query);
			if($query) echo "Friend request sent";
			else echo "Error";
		}
	}
	
	//$isSent = false;
	
	mysqli_close($connect);
?>
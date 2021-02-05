<?php 
	//session_start();
	require_once('connect.php');
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$friendship_id = mysqli_real_escape_string($connect,$data->friendshipID);
	//$friendship_id = 48;
	
	$query = "UPDATE friends SET friends.friend_ignored = 1 WHERE friends.id = $friendship_id";
	
	$query = mysqli_query($connect, $query);
	
	if($query) {
		echo "Your ignored that request";
	} else {
		echo "Error";
	}
	
	mysqli_close($connect);
?>
<?php 
	//session_start();
	require_once('connect.php');
	require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$post_id = mysqli_real_escape_string($connect,$data->postID);
	
	$query = "DELETE FROM `wall` WHERE `wall`.`wall_post_id` = $post_id";
	
	$query = mysqli_query($connect, $query);
	
	if($query) {
		echo "Post deleted";
	} else {
		echo "Error";
	}
	
	mysqli_close($connect);
?>
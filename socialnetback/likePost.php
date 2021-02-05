<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	
	//echo $_SESSION['vlad'];
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	$postId = form_validate(mysqli_real_escape_string($connect,$data->postId));
	
	if(!empty($postId)) {
		$query = "SELECT * FROM `post_likes` WHERE post_id = $postId and user_id = $sessionId";
		$query = mysqli_query($connect, $query);
		$query2 = "SELECT likes FROM wall WHERE wall_post_id = $postId";
		$query2 = mysqli_query($connect, $query2);
		if($query2) {
			$row = mysqli_fetch_array($query2);
			$likes_num = $row[0];
		}
		if(mysqli_num_rows($query) > 0) {
			$likes_num--;
			$query = "DELETE FROM `post_likes` WHERE post_id = $postId and user_id = $sessionId";
			$query2 = "UPDATE wall SET likes=$likes_num WHERE wall_post_id=$postId";
		} else {
			$likes_num++;
			$query = "INSERT INTO `post_likes` (`id`, `post_id`, `user_id`, `like_date`) VALUES (NULL, $postId, $sessionId, NOW())";
			$query2 = "UPDATE wall SET likes=$likes_num WHERE wall_post_id=$postId";
		}
	}
	$query = mysqli_query($connect, $query);
	$query2 = mysqli_query($connect, $query2);
	
	if($query) {
		echo 'liked';
	} else {
		echo "error";
	}
	
	mysqli_close($connect);
?>
<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	
	//echo $_SESSION['vlad'];
	require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	$post_text = form_validate(mysqli_real_escape_string($connect,$data->postText));
	
	$postDate = date('Y-m-d h:i:sa');
	
	if(!empty($post_text)) {
		$query = "INSERT INTO `wall` (`wall_post_id`, `wall_owner`, `wall_post_author`, `wall_post_text`, `wall_post_date`) 
				  VALUES (NULL, $id, '$sessionId', '$post_text', '$postDate')";	
	}
	
	$query = mysqli_query($connect, $query);
	
	if($query) {
		echo "new post added";
	} else {
		echo "error";
	}
	
	mysqli_close($connect);
?>
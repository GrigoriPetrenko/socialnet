<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$photo_id = mysqli_real_escape_string($connect,$data->photoID);
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	
	$query = "SELECT * FROM photos WHERE photo_id = $photo_id";
	$query = mysqli_query($connect, $query);
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_assoc($query);
		$source = $row['photo_url'];
	}
	
	$query = "DELETE FROM `photos` WHERE photos.photo_id = $photo_id and photos.user_owner = $sessionId";
	
	$query = mysqli_query($connect, $query);
	
	if($query && unlink($source)) {
		echo "Photo deleted";
	} else {
		echo "Error";
	}
	
	mysqli_close($connect);
?>
<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	
	//echo $_SESSION['vlad'];
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	$text = form_validate(mysqli_real_escape_string($connect,$data->text));
	$userId = mysqli_real_escape_string($connect,$data->userId);
	
	$messDate = date('Y-m-d h:i:sa');
	
	if(!empty($text)) {
		$query = "INSERT INTO `messages` (`message_id`, `message_sender`, `message_rec`, `message_text`, `message_date`) 
				  VALUES (NULL, $sessionId, $userId, '$text', NOW())";	
	}
	
	$query = mysqli_query($connect, $query);
	
	if($query) {
		echo "message has been sent";
	} else {
		echo "error";
	}
	
	mysqli_close($connect);
?>
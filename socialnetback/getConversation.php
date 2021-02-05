<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	$data = json_decode(file_get_contents('php://input'));
	$userId = mysqli_real_escape_string($connect,$data->userId);
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	
	$query = "SELECT users.user_name, users.user_surname, users.user_avatar, messages.message_sender, messages.message_text, messages.message_date FROM messages 
			  INNER JOIN users ON messages.message_sender = users.user_id 
			  WHERE (messages.message_sender = $sessionId and messages.message_rec = $userId) 
					or (messages.message_sender = $userId and messages.message_rec = $sessionId)
					ORDER BY messages.message_date ASC";
					
	$query = mysqli_query($connect, $query);

	$output = array();
	
	
	if (mysqli_num_rows($query) > 0) {
		while($row = mysqli_fetch_assoc($query)) {
			$output[] = $row;
		}
		echo json_encode($output);
	} else {
		echo "";
	}
	
	mysqli_close($connect);
?>
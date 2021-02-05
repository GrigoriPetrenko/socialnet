<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	
	$query = "SELECT user_id, user_name, user_surname, user_avatar, user_verified FROM users

			  WHERE user_id IN

			 (SELECT DISTINCT message_rec as 'penpal' FROM messages WHERE message_sender = $sessionId

			  UNION 

			  SELECT DISTINCT message_sender as 'penpal' FROM messages WHERE message_rec = $sessionId)";
					
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
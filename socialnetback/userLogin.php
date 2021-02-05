<?php
	require_once('connect.php');
	require_once('formValid.php');
		
	$data = json_decode(file_get_contents('php://input'));
	
	$email = form_validate(mysqli_real_escape_string($connect,$data->email));
	$password = md5(mysqli_real_escape_string($connect, $data->password));
	
	if(user_check_email($email)) {
		$query = "SELECT * FROM `users` WHERE `user_email` = '$email' and `user_password` = '$password'";
		$query = mysqli_query($connect,$query);
		
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_assoc($query); 
			session_start();
			$_SESSION["user"] = $row["user_id"];
			$sessionId = $_SESSION["user"];
			$query = "INSERT INTO users_online (id, user_session_id, user_session_time) VALUES (NULL, $sessionId, NOW())";
			$query = mysqli_query($connect,$query);
			echo $sessionId;
		} else {
			echo 'user not registered';
		} 
	}
	
	mysqli_close($connect);
?>
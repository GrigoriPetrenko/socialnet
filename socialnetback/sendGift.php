<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	
	//echo $_SESSION['vlad'];
	//require_once('userId.php');
	
	$data = json_decode(file_get_contents('php://input'));
	$sessionId = form_validate(mysqli_real_escape_string($connect,$data->sessionId));
	$user_receiver = form_validate(mysqli_real_escape_string($connect,$data->userId));
	$gift_id = form_validate(mysqli_real_escape_string($connect,$data->giftId));
	$query1 = "SELECT gift_price FROM gifts WHERE gift_id = $gift_id";
	$query1 = mysqli_query($connect,$query1);
	if($query1) {
		$row = mysqli_fetch_array($query1);
		$gift_price = $row[0];	
	}
	$query2 = "SELECT user_balance FROM users WHERE user_id = $sessionId";
	$query2 = mysqli_query($connect,$query2);
	if($query2) {
		$row = mysqli_fetch_array($query2);
		$user_balance = $row[0];	
	}
		
	if(!empty($gift_id)) {
		if($user_balance - $gift_price < 0) {
			echo "You have no enough money for sending this gift";
		} else {
			$query = "INSERT INTO `user_gifts` (`id`, `user_sender`, `user_rec`, `gift_id`, `receive_date`) 
				      VALUES (NULL, $sessionId, $user_receiver, $gift_id, NOW())";
			$query = mysqli_query($connect, $query);
		}
	}
	
	if(isset($query)) {
		$query3 = "UPDATE users SET user_balance = user_balance - $gift_price WHERE user_id=$sessionId";
		$query = mysqli_query($connect, $query3);
		echo "gift was sent to the user";
	} else {
		echo "error";
	}
	
	mysqli_close($connect);
?>
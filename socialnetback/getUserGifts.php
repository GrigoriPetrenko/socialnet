<?php 
	//session_start();
	require_once('connect.php');
	
	require_once('userId.php');
	
	$query = "SELECT * FROM user_gifts INNER JOIN gifts ON user_gifts.gift_id = gifts.gift_id
		      WHERE user_gifts.user_rec = $id ORDER BY user_gifts.receive_date DESC";
	
	$query = mysqli_query($connect, $query);
	$output = array();
	
	if (mysqli_num_rows($query) > 0) {
		while($row = mysqli_fetch_array($query)) {
			$output[] = $row; 
		}
		echo json_encode($output);
	} else {
		echo "";
	}
	
	mysqli_close($connect);
?>
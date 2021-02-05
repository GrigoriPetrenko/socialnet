<?php 
	//session_start();
	require_once('connect.php');
	
	$query = "SELECT * FROM `users` ORDER BY `users`.`user_id` DESC LIMIT 10";
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
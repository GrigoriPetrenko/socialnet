<?php 
	//session_start();
	require_once('connect.php');
	
	require_once('userId.php');
	
	$query = "SELECT * FROM users 
			  LEFT JOIN countries ON users.user_country = countries.country_id 
			  LEFT JOIN relationships ON users.user_marital_status = relationships.relationship_id
		      WHERE `user_id` = $id";
	
	$query = mysqli_query($connect, $query);
	$output = array();
	
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_assoc($query);
		echo json_encode($row);
	} else {
		echo "0 results";
	}
	
	mysqli_close($connect);
?>
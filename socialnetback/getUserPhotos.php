<?php 
	//session_start();
	require_once('connect.php');
	
	require_once('userId.php');
	
	$query = "SELECT distinct * FROM `photos` WHERE `user_owner` = $id ORDER BY upload_date DESC";
	
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
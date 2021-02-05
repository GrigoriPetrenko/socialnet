<?php 
	//session_start();
	
	require_once('connect.php');
	
	$query = "SELECT * FROM gifts";
		  
	$query = mysqli_query($connect, $query);

	$output = array();
	
	
	if (mysqli_num_rows($query) > 0) {
		while($row = mysqli_fetch_assoc($query)) {
			$output[] = $row;
		}
		echo json_encode($output);
	} else {
		echo "0 results";
	}
	
	mysqli_close($connect);
?>
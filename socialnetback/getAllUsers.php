<?php 
	//session_start();
	
	require_once('connect.php');
	
	$query = "SELECT users.user_id, users.user_name, countries.country_name, countries.country_flag, users.user_surname, users.user_avatar, users.user_rating, users.user_verified FROM 
			  users LEFT JOIN countries on users.user_country = countries.country_id
	          ORDER BY users.user_rating DESC";
		  
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
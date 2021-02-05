<?php 
	//session_start();
	require_once('connect.php');
	
	//echo $_SESSION['vlad'];
	require_once('userId.php');
				  
	$query = "SELECT distinct user_id, users.user_name, users.user_surname, users.user_avatar, users.user_rating, users.user_verified,
			  countries.country_name, countries.country_flag 
			  FROM users LEFT JOIN countries ON users.user_country = countries.country_id 
			  WHERE user_id in 
			 (SELECT friend_id as 'user_id' FROM friends where user_id = $id and friends_status = 1
			  UNION
			  SELECT user_id as 'user_id' FROM friends where friend_id = $id and friends_status = 1)
			  ORDER BY users.user_rating DESC";
	
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
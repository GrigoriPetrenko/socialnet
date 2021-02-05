<?php 
	require_once('userId.php');
	require_once('connect.php');			  
	$query = "SELECT friends.id, friends.friend_ignored, users.user_name, users.user_surname, users.user_avatar, users.user_verified, countries.country_name, countries.country_flag
			  from friends 
			  INNER JOIN users ON friends.user_id = users.user_id
			  LEFT JOIN countries ON users.user_country = countries.country_id
			  where friends.friend_id = $id and friends.friends_status = 0 and friends.friend_ignored = 0 ORDER BY users.user_rating";
	
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
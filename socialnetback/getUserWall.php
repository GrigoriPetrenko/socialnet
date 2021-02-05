<?php 
	//session_start();
	require_once('connect.php');
	
	require_once('userId.php');
	
	$query = "SELECT users.user_name, users.user_surname, users.user_avatar, users.user_verified, wall.wall_post_id, wall.wall_post_author, wall.wall_owner, wall.wall_post_text, wall.wall_post_date, wall.likes
			  FROM users INNER JOIN wall ON 
			  users.user_id = wall.wall_post_author WHERE wall.wall_owner = $id ORDER BY wall.wall_post_date DESC";
	
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
<?php 
	//session_start();
	require_once('connect.php');
	
	require_once('userId.php');
	
	/*$query = "SELECT wall.wall_post_author, wall.wall_post_text, wall.wall_post_date, users.user_name, users.user_surname, users.user_avatar, users.user_verified
				FROM wall INNER JOIN friends INNER JOIN users
				ON users.user_id = friends.friend_id
				WHERE wall.wall_post_author =  wall.wall_owner 
				AND wall.wall_post_author = friends.friend_id 
				AND friends.friends_status = 1
				AND friends.user_id = $id ORDER BY wall.wall_post_date DESC";*/
				
	$query = "SELECT wall.wall_post_id, wall.wall_post_author, wall.wall_post_text, wall.wall_post_date, wall.likes, users.user_name, users.user_surname, users.user_avatar, users.user_verified
			  FROM wall INNER JOIN users ON wall.wall_post_author = users.user_id
			  WHERE user_id in 
			 (SELECT friend_id as 'one' FROM friends where user_id = $id and friends_status = 1
			  UNION
			  SELECT user_id as 'one' FROM friends where friend_id = $id and friends_status = 1)
			  and wall.wall_post_author =  wall.wall_owner 
			  ORDER BY wall.wall_post_date DESC";
	
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
<?php 
	//session_start();
	//echo $_SESSION['user'];
	require_once('userId.php');
	require_once('connect.php');			  
	$query = "(select users.user_name as 'user_name', users.user_surname as 'user_surname', users.user_avatar as 'user_avatar', users.user_id as 'user_id', COUNT(*) as counter from friends INNER JOIN users on friends.user_id = users.user_id where friends.friend_id in 
			  (select friends.friend_id FROM friends where friends.user_id = $id and friends.friends_status = 1) 
			  and 
			  friends.user_id != $id and friends.user_id not in 
			  (SELECT friend_id as 'one' FROM friends where user_id = $id and friends_status = 1
			  UNION
			  SELECT user_id as 'one' FROM friends where friend_id = $id and friends_status = 1) 
			  GROUP by friends.user_id)
              
              UNION

			  (select users.user_name as 'user_name', users.user_surname as 'user_surname', users.user_avatar as 'user_avatar', users.user_id as 'user_id', COUNT(*) as counter from friends INNER JOIN users on friends.friend_id = users.user_id where friends.user_id in 
			  (select friends.user_id FROM friends where friends.friend_id = $id and friends.friends_status = 1) 
			  and 
			  friends.friend_id != $id and friends.friend_id not in 
			  (SELECT friend_id as 'one' FROM friends where user_id = $id and friends_status = 1
			  UNION
			  SELECT user_id as 'one' FROM friends where friend_id = $id and friends_status = 1) 
			  GROUP by friends.friend_id)
			  
			  ORDER BY rand()";	  
	$query = mysqli_query($connect, $query);
	$output = array();
	if (mysqli_num_rows($query) > 0) {
		while($row = mysqli_fetch_array($query)) {
			$output[] = $row; 
		}
		echo json_encode($output);
	} else if(mysqli_num_rows($query) == 0) {
		$query = "select users.user_name, users.user_surname, users.user_avatar, users.user_id from users
			  WHERE user_id != $id and user_id not in 
			  (SELECT friend_id as 'one' FROM friends where user_id = $id and friends_status = 1
			  UNION
			  SELECT user_id as 'one' FROM friends where friend_id = $id and friends_status = 1)
			  order by rand()
			  LIMIT 10";
		$query = mysqli_query($connect, $query);
		while($row = mysqli_fetch_array($query)) {
			$output[] = $row; 
		}
		echo json_encode($output);
	}
	
	mysqli_close($connect);
?>
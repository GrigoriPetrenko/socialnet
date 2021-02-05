<?php
	require_once('connect.php');
	require_once('formValid.php');
		
	$data = json_decode(file_get_contents('php://input'));
	
	$search_query = form_validate(mysqli_real_escape_string($connect,$data->searchQuery));
	
	if(stristr($search_query, ' ')) {
		$partials = explode(" ", $search_query);
		$part_one = $partials[0];
		$part_two = $partials[1];
	} else {
		$part_one = $part_two = $search_query;
	}
	
	$query = "SELECT users.user_id, users.user_name, users.user_surname, countries.country_name, countries.country_flag, users.user_rating, users.user_avatar, users.user_verified 
			  FROM users LEFT JOIN countries ON users.user_country = countries.country_id
			  WHERE 
			  (users.user_name LIKE '$search_query' or users.user_surname LIKE '$search_query') or
			  (users.user_name LIKE '$search_query%' or users.user_surname LIKE '$search_query%') or 
			  (users.user_name LIKE '$part_one%' and users.user_surname LIKE '$part_two%')
			  ORDER BY user_rating DESC";
	
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
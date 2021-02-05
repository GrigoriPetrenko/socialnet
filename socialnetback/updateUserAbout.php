<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	require_once('userId.php');
	
	//$userID = $_GET['id'];
	
	$data = json_decode(file_get_contents('php://input'));
	//general info
	$user_name = form_validate(mysqli_real_escape_string($connect,$data->userName));
	$user_surname = form_validate(mysqli_real_escape_string($connect,$data->userSurName));
	$user_birthday = mysqli_real_escape_string($connect,$data->userBirthday);
	$user_country = form_validate(mysqli_real_escape_string($connect,$data->userCountry));
	$user_marital_status = form_validate(mysqli_real_escape_string($connect,$data->userMaritalStatus));
	$user_gender = form_validate(mysqli_real_escape_string($connect,$data->userGender));
	$user_short_bio = form_validate(mysqli_real_escape_string($connect,$data->userShortBio));

	//socials
	$user_vk = form_validate(mysqli_real_escape_string($connect,$data->userVk));
	$user_fb = form_validate(mysqli_real_escape_string($connect,$data->userFb));
	$user_instagram = form_validate(mysqli_real_escape_string($connect,$data->userInstagram));
	$user_twitter = form_validate(mysqli_real_escape_string($connect,$data->userTwitter));
	$user_youTube = form_validate(mysqli_real_escape_string($connect,$data->userYouTube));
	$user_linkedin = form_validate(mysqli_real_escape_string($connect,$data->userLinkedin));
	$user_google_plus = form_validate(mysqli_real_escape_string($connect,$data->userGooglePlus));
	//about
	$activity = form_validate(mysqli_real_escape_string($connect,$data->activity));
	$interests = form_validate(mysqli_real_escape_string($connect,$data->interests));
	$fav_mus = form_validate(mysqli_real_escape_string($connect,$data->favMus));
	$fav_mov = form_validate(mysqli_real_escape_string($connect,$data->favMov));
	$fav_books = form_validate(mysqli_real_escape_string($connect,$data->favBooks));
	$fav_games = form_validate(mysqli_real_escape_string($connect,$data->favGames));
	
	$query = "UPDATE users SET 
			  user_name = '$user_name',
			  user_surname = '$user_surname',
			  user_birthday = '$user_birthday',
			  user_country = $user_country,
			  user_marital_status = $user_marital_status,
			  user_gender = '$user_gender',
			  user_short_bio = '$user_short_bio',
			  user_vk = '$user_vk',
			  user_fb = '$user_fb',
			  user_instagram = '$user_instagram',
			  user_twitter = '$user_twitter',
			  user_youTube = '$user_youTube',
			  user_linkedin = '$user_linkedin',
			  user_google_plus = '$user_google_plus',
			  user_activity = '$activity',
			  user_interests = '$interests',
			  user_fav_mus = '$fav_mus',
			  user_fav_mov = '$fav_mov',
			  user_fav_books = '$fav_books',
			  user_fav_games = '$fav_games'
			  WHERE user_id = $id";
			  
	$query = mysqli_query($connect, $query);
	$output = array();
	
	if ($query) {
		echo "User info updated successfully";
	} else {
		echo "Error";
	}
	
	mysqli_close($connect);
?>
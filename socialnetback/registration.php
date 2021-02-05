<?php
	require_once('connect.php');
	require_once('formValid.php');
	
	$data = json_decode(file_get_contents('php://input'));
	
	$name = form_validate(mysqli_real_escape_string($connect,$data->firstname));
	$surname = form_validate(mysqli_real_escape_string($connect, $data->surname));
	$email = form_validate(mysqli_real_escape_string($connect, $data->email));
	$password = md5(mysqli_real_escape_string($connect, $data->password));
	$rep_password = md5(mysqli_real_escape_string($connect, $data->rep_password));
	$gender = mysqli_real_escape_string($connect, $data->gender);
	define('DEFAULT_BALANCE', 100);
	
	$check_user = "SELECT * FROM `users` WHERE `user_email` = '$email'";
	$check_user = mysqli_query($connect, $check_user);
	
	if (mysqli_num_rows($check_user) > 0) {
		echo 'User with that mail is already exists';
	} else {	
		if(user_check_pass($password) && user_check_pass_eq($password, $rep_password) && user_check_email($email) && user_check_name($name) && user_check_name($surname)) {
			$query = "INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `user_name`, `user_surname`, `user_gender`,`user_balance`,`user_role_fk`) VALUES (NULL, '$email', '$password', '$name', '$surname', '$gender',".DEFAULT_BALANCE.",2)";
			$query = mysqli_query($connect, $query);
			
			if($query) echo "user added";
			
		} else echo "Wrong data";
	}
	
	mysqli_close($connect);
?>
<?php 
	//session_start();
	require_once('connect.php');
	require_once('formValid.php');
	
	//echo $_SESSION['vlad'];
	//require_once('userId.php');
	
	if(!empty($_FILES)) {
		$file_name = $_FILES['file']['name'];
		$sessionId = $_POST['sessionId'];
		$path = 'images/'.$file_name;
		if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
			$query = "UPDATE users SET user_avatar = '$path' WHERE user_id=$sessionId";
			if(mysqli_query($connect, $query)) {
				echo "avatar updated";
			} else {
				echo "uploaded but not saved";
			}
		}
	} else {
		echo 'Error';
	}
	
	
	mysqli_close($connect);
?>
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
		$upload_date = date('Y-m-d h:i:sa');
		if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
			$query = "INSERT INTO `photos` (`photo_id`, `user_owner`, `photo_url`, `upload_date`) VALUES (NULL, $sessionId, '$path','$upload_date')";
			if(mysqli_query($connect, $query)) {
				echo "new photo added";
			} else {
				echo "uploaded but not saved";
			}
		}
	} else {
		echo "Error";
	}
	
	
	mysqli_close($connect);
?>
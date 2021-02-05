<?php
	function form_validate($data) {
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	function user_check_pass_eq($pass1,$pass2) {
		$flag = false;
		if(!empty($pass1) && !empty($pass2) && $pass1 === $pass2) {
			$flag = true;
		}
		return $flag;
	}
	function user_check_email($e_mail) {
		$flag = false;
		if (filter_var($e_mail, FILTER_VALIDATE_EMAIL)) {
			$flag = true;
		}
		return $flag;
	}
	function user_check_name($name) {
		$flag = false;
		if (preg_match("/^[a-zA-Z ]*$/",$name)) {
			$flag = true;
		}
		return $flag;
	}
	function user_check_pass($pass) {
		$flag = false;
		if (strlen($pass) > 8 && preg_match("#[0-9]+#", $pass) && preg_match("#[a-zA-Z]+#", $pass)) {
			$flag = true;
		}
		return $flag;
	}
?>
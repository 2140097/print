<?php

	session_start();
	session_destroy();

	session_start();
	include '../includes/dbh.php';

	$username = $_POST['username'];
	$password_ = $_POST['password'];
	$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=? ");
	$password = md5($password_);
	$stmt->bind_param("ss", $username, $password);
	$stmt->execute();
	$stmt->bind_result($uid, $username_queried, $password_queried, $auth);
	$stmt->store_result();
	if($stmt->num_rows > 0) {	//check row num
		if($stmt->fetch()){		//fetch row contents
			$_SESSION['uid'] = $uid;
			$_SESSION['auth'] = $auth;
			$_SESSION['username'] = $username_queried;
			if($auth == 'admin'){
			header("Location: ../pages/listrequest.php");
			}else if($auth == 'printing staff'){
				header("Location: ../pages/listprint.php");
			}else if($auth == 'client' || $auth == 'others'){
				header("Location: ../process/chkb.php");
			}
		}
	} else {
		header("Location: ../alert_msg/invalid_login.php");
	}
	$stmt->close();
	$conn->close();
?>
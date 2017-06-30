<?php

    session_start();
	if(isset($_SESSION['uid']) && isset($_SESSION['auth'])){
		$session_auth = $_SESSION['auth'];
		if($session_auth == 'printing staff'){
			//do nothing
		}else {
			header('Location: ../alert_msg/page_not_found.php');
		}
	}else {
		header('Location: ../alert_msg/page_not_found.php');
	}

include '../includes/dbh.php';

if(isset($_GET['printnum'])){
    $requestno = $_GET['printnum'];
    $sql = "UPDATE prnt_request SET status='failed', pending_deduction=NULL WHERE request_no='$requestno' ";
    if($conn->query($sql)){
        header('Location: ../pages/listprint.php');
    }else echo "<p>update failed</p>";
}

?>
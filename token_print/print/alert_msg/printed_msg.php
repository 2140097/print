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
?>
<html>
<head>
	<title>Printed</title>
    <link rel="stylesheet" type="text/css" href="../includes/style.css" />
<head>
<body>
    <div id='printed_msg_box' class='alert_msg'>
        <p>Status: printed</p>
        <a href="../pages/listprint.php">ok</a>
    <div>
</body>
</html>
<?php
    session_start();
	if(isset($_SESSION['uid']) && isset($_SESSION['auth'])){
		$session_auth = $_SESSION['auth'];
		if($session_auth == 'admin'){
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
    <title>file not found</title>
    <link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>
<body>
    <div id="filenotfoundbox" class='alert_msg'>
        <p>file not found</p>
        <a href="../pages/adduser.php">ok</a>
    </div>
</body>
</html>
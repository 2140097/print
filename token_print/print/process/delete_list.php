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
    <title>Add user</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>
<body>
    <div id='token_reset_box'>
        <label id='reset_tokens_label'>Delete user list?</label>
        <form action='delete_list_verify.php' method='POST'>
            <label>Enter password:</label><br>
            <input type='password' name='password'>
            <div id='resetbtnbox'>
                <input type='submit' value='confirm' id='reset_pw_btn'>
            <div>
        </form>
        <a href='../pages/userlist.php'>cancel</a>
    </div>
</body>
</html>
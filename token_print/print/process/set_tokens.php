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
    <title>Set tokens</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>
<body>
    <div id='token_reset_box'>
        <label id='reset_tokens_label'>Set tokens:
            <?php
                if(isset($_GET['token_set_num'])){
                    $idnum = $_GET['token_set_num'];
                    echo $idnum;
                }
            ?>
        </label>
        <form action='token_set_verify.php' method='POST'>
            <label>Token amount:</label><br>
            <input style='display: none' type='text' name='id_to_reset' value='<?php echo $idnum;?>'>
            <input type='number' name='token_set' required><br>
            <label>Enter password:</label><br>
            <input type='password' name='password' required>
            <div id='resetbtnbox'>
                <input type='submit' value='confirm' id='reset_pw_btn'>
            <div>
        </form>
        <a href='../pages/userlist.php'>cancel</a>
    </div>
</body>
</html>
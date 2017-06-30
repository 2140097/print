<?php
    session_start();
	if(isset($_SESSION['uid'])){
		//do nothing
	}else{
        header('Location: ../alert_msg/page_not_found.php');
    }
?>
<html>
<head>
    <title>Change password</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>
<body>
    <div id='token_reset_box'>
        <label id='reset_tokens_label'>Change password?</label>
        <form action='../process/change_pw_verify.php' method='POST'>
            <label>Current password:</label><br>
            <input type='password' name='curr_pw' required><br>
            <label>New password:</label><br>
            <input type='password' name='new_pw' required>
            <div id='resetbtnbox'>
                <input type='submit' value='confirm' id='reset_pw_btn'>
            <div>
        </form>
        <?php
            if(isset($_SESSION['auth'])){
                if($_SESSION['auth'] == 'admin'){
                    $cancel = "../pages/listrequest.php";
                }else if($_SESSION['auth'] == 'printing staff'){
                    $cancel = "../pages/listprint.php";
                }else if($_SESSION['auth'] == 'client'){
                    $cancel = "../pages/client_request_list.php";
                }
            }
        ?>
        <a href='<?php echo $cancel;?>'>cancel</a>
    </div>
</body>
</html>
<?php
    session_start();
	if(isset($_SESSION['uid'])){
		//do nothing
	}else {
		header('Location: ../alert_msg/page_not_found.php');
	}
?>
<html>
<head>
    <title>Password changed</title>
    <link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>
<body>
    <div id="deletefailedbox" class='alert_msg'>
        <p>Password changed</p>
        <?php
            if(isset($_SESSION['auth'])){
                if($_SESSION['auth'] == 'admin'){
                    $cancel = "../pages/listrequest.php";
                }else if($_SESSION['auth'] == 'printing staff'){
                    $cancel = "../pages/listprint.php";
                }else if($_SESSION['auth'] == 'client'){
                    $cancel = "../pages/client_request_list.php";
                }
            }else{
                header('Location: ../alert_msg/page_not_found.php');
            }
        ?>
        <a href="<?php echo $cancel;?>">ok</a>
    </div>
</body>
</html>
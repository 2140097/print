<?php
    session_start();
	if(isset($_SESSION['uid']) && isset($_SESSION['auth'])){
		$session_auth = $_SESSION['auth'];
		if($session_auth == 'client'){
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
    <title>tokens</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>

<body>
    <?php
        include '../includes/nav.php';
    ?>

    <?php
    include '../includes/dbh.php';

        if(isset($_SESSION['uid'])){
            $uid = $_SESSION['uid'];
        }else{
            header('Location: ../pages/out.php');
        }
        
        $sql = "SELECT tokens FROM clients WHERE uid='$uid'";

        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()){
            echo "<div id='chkbox'><p>You have " . $row['tokens'] . " print tokens left.</p></div>";
        }
    ?>

</body>

</html>
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
        <title>Assessed</title>
	    <meta charset="UTF-8">
	    <link rel="stylesheet" type="text/css" href="../includes/style.css" />
    </head>
    <body>
    <div id='assessed_box'>
        <?php
            include '../includes/dbh.php';

            $deductions = $_POST['deduction'];
            $requestnum  = $_POST['requestnum'];

            $sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE request_no='$requestnum'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $tokens = $row['tokens'];
                    $idnum = $row['idnum'];
                }

                if($tokens < $deductions){
                    echo "<label>current tokens: </label>" . $tokens . "<br>";
                    echo "<label>tokens needed for print: </label>" . $deductions . "<br>";
                    echo "<p>invalid token amount</p>";
                }else{
                    
                    $sql = "UPDATE prnt_request SET status='assessed', pending_deduction='$deductions' 
                    WHERE request_no='$requestnum'";
                    if($conn->query($sql)){
                        echo "<p>successfully assessed</p>";
                    }
                }

            }

        ?>
        <a href="../pages/listrequest.php">ok</a>
    </div>
    </body>
</html>
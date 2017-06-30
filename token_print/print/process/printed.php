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

    $sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE request_no='$requestno'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $idnum = $row['idnum'];
            $tokens = $row['tokens'];
            $deductions = $row['pending_deduction'];
        }

        $new_token_count = $tokens-$deductions;
        $sql2 = "UPDATE prnt_request SET status='printed', pending_deduction=NULL WHERE request_no='$requestno' ";
        $sql3 = "UPDATE clients SET tokens='$new_token_count' WHERE idnum='$idnum'";
        if($conn->query($sql2) && $conn->query($sql3)){
            header('Location: ../alert_msg/printed_msg.php');
        }else echo "<p>update failed</p>";
    }
}

?>
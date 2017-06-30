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

include '../includes/dbh.php';

$delete_idnum = $_GET['user_delete_num'];
$sql="SELECT * FROM clients WHERE idnum='$delete_idnum'";

$result = $conn->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $delete_uid = $row['uid'];
    }

    $sql2="DELETE FROM clients WHERE uid='$delete_uid'";
    $sql3="DELETE FROM users WHERE uid='$delete_uid'";
    if($conn->query($sql2) && $conn->query($sql3)){
        $date = date("Y-m-d");
        $details = "user account " . $_GET['user_delete_num'] . " was deleted";
        $sql_report = "INSERT INTO reports (report_num, date, details) VALUES ('0', '$date', '$details')";
        if($conn->query($sql_report)){
            header('Location: ../pages/userlist.php');
        }
    }else {
        header('Location: ../alert_msg/delete_not_valid.php');
    }
}

?>
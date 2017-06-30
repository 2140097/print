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

    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['idnum']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['acctype'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $idnum = $_POST['idnum'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $acctype = $_POST['acctype'];

        $name = $lastname . ', ' . $firstname;

        $sql1 = "INSERT INTO users (uid, username, password, auth) VALUES ('0', '$username', '$password', 'client')";

        if($conn->query($sql1)){
            $sql2 = "SELECT * from users ORDER BY uid DESC LIMIT 1";
            $result = $conn->query($sql2);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $uid = $row['uid'];
                }
            }

            if(isset($acctype)){
                if($acctype == 'graduate'){
                    $tokens = "750";
                }else{
                    $tokens = "500";
                }
            }

            if(isset($uid)){
                $sql3 = "INSERT INTO clients (idnum, name, uid, tokens, type) VALUES ('$idnum', '$name', '$uid', '$tokens', '$acctype')";
                if($conn->query($sql3)){
                    $date = date("Y-m-d");
                    $details = "user account " . $idnum . " was added";
                    $sql_report = "INSERT INTO reports (report_num, date, details) VALUES ('0', '$date', '$details')";
                    if($conn->query($sql_report)){
                        header('Location: ../alert_msg/users_added.php');
                    }
                }else{
                    $sql4 = "DELETE FROM users WHERE uid='$uid'";
                    if($conn->query($sql4)){
                        header('Location: ../alert_msg/csv_error.php');
                    }
                }
            }

        }else{
            header('Location: ../alert_msg/csv_error.php');
        }
    }else{
        header('Location: ../alert_msg/invalid_input.php');
    }
?>
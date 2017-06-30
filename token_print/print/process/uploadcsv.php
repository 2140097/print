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
    if(isset($_POST['uploadcsv']) && $_FILES['csvfile']['size'] > 0){

            include 'rwcsv.php';
            $csvfile = $_FILES['csvfile']['tmp_name'];

            //tells browser that format is plain text
            //header('Content-Type: text/plain');
            
            $csv_array = readcsv($csvfile);

            $arraylength = count($csv_array);

            for($x = 1; $x < $arraylength; $x++){
                $idnum = $csv_array[$x][0];
                $name = $csv_array[$x][1];
                $username = $csv_array[$x][2];
                $password = $csv_array[$x][3];
                $type = $csv_array[$x][4];

                $sql = "INSERT INTO users (uid, username, password, auth) VALUES ('0', '$username', '$password', 'client')";
                if($conn->query($sql)){
                    $sql1 = "SELECT * from users ORDER BY uid DESC LIMIT 1";
                    $result = $conn->query($sql1);
                    $adduserquery1 = true;
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $uid = $row['uid'];
                        }
                    }
                    
                    if($type == 'graduate'){
                        $tokens = 750;
                    }else{
                        $tokens = 500;
                    }

                    $sql2 = "INSERT INTO clients (idnum, name, uid, tokens, type) VALUES ('$idnum', '$name', '$uid', '$tokens', '$type')";
                    if($conn->query($sql2)){
                        $adduserquery2 = true;
                    }else{
                        header('Location: ../alert_msg/csv_error.php');
                    }
                }
            }     
        }else{
            header("Location: ../alert_msg/file_not_found.php");
        }
    if(isset($adduserquery1) && isset($adduserquery2)){
        if($adduserquery1 == true && $adduserquery2 == true){
            $date = date("Y-m-d");
            $sql_report = "INSERT INTO reports (report_num, date, details) VALUES ('0', '$date', 'csv upload: user/s added')";
            if($conn->query($sql_report)){
                header('Location: ../alert_msg/users_added.php');
            }
        }
    }else{
        header('Location: ../alert_msg/csv_error.php');
    }
?>
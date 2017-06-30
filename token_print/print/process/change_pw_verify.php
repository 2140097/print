<?php

session_start();
include '../includes/dbh.php';
if(isset($_SESSION['uid'])){
    $currpw_ = $_POST['curr_pw'];
    $newpw_ = $_POST['new_pw'];
    $newpw = md5($newpw_);

    $change_pw_id = $_SESSION['uid'];
    $sql = "SELECT * FROM users WHERE uid='$change_pw_id'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $current_password = $row['password'];
            $current_username = $row['username'];
        }
        $currpw = md5($currpw_);
        if($currpw == $current_password){
            $stmt = $conn->prepare("UPDATE users SET password=? where uid='$change_pw_id'");
            $stmt->bind_param("s", $newpw);
            $stmt->execute();

            //reports
            $date = date("Y-m-d");
            $details = "user account " . $current_username . " password was changed";
            $sql_report = "INSERT INTO reports (report_num, date, details) VALUES ('0', '$date', '$details')";
            if($conn->query($sql_report)){
                header('Location: ../alert_msg/password_changed.php');
            }
        }else{
        header('Location: ../alert_msg/password_not_changed.php');
    }
    }else{
        header('Location: ../alert_msg/page_not_found.php');
    }

}else{
    header('Location: ../alert_msg/page_not_found.php');
}

?>
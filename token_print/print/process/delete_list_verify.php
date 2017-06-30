<?php
        session_start();
        include '../includes/dbh.php';
        if(isset($_SESSION['uid'])){
            $uid = $_SESSION['uid'];

            if(isset($_POST['password'])){
                $sql = "SELECT * FROM users where uid = '$uid'";
                $reset_password_ = $_POST['password'];
                $reset_password = md5($reset_password_);
                $reset_username = $_SESSION['username'];
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $username_chk = $row['username'];
                        $password_chk = $row['password'];
                    }

                    if($reset_username == $username_chk && $reset_password == $password_chk ){

                        $sql1 = "SELECT * FROM prnt_request";
                        $result1 = $conn->query($sql1);
                        if($result1->num_rows > 0){
                            header('Location: ../alert_msg/delete_not_valid.php');
                        }else{
                            $sql3 = "DELETE * FROM clients";
                            $sql2 = "DELETE * FROM users where auth='client'";
                            if($conn->query($sql3) && $conn->query($sql2)){
                                $is_reset = true;
                            }else{
                                echo 'database broken';
                            }

                            if($is_reset = true){
                                $date = date("Y-m-d");
                                $sql_report = "INSERT INTO reports (report_num, date, details) VALUES ('0', '$date', 'user/s deleted')";
                                if($conn->query($sql_report)){
                                    header('Location: ../pages/userlist.php');
                                }
                            }
                        }
                    }else{
                        header('Location: ../alert_msg/delete_not_valid.php');
                    }

                }else{
                    header('Location: ../alert_msg/delete_not_valid.php');
                }
            }
        }
    ?>
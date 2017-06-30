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
                        $sql2 = "SELECT * from clients";
                        $result2 = $conn->query($sql2);
                        while($client_row = $result2->fetch_assoc()){
                            $reset_idnum = $client_row['idnum'];
                            $reset_type = $client_row['type'];
                            
                            if($reset_type == 'graduate'){
                                $tokens = 750;
                            }else{
                                $tokens = 500;
                            }

                            $sql3 = "UPDATE clients SET tokens = '$tokens' WHERE idnum = '$reset_idnum'";
                            if($conn->query($sql3)){
                                $is_reset = true;
                            }else{
                                echo 'database broken';
                            }
                        }

                        if($is_reset = true){
                            $date = date("Y-m-d");
                            $sql_report = "INSERT INTO reports (report_num, date, details) VALUES ('0', '$date', 'tokens were reset')";
                            if($conn->query($sql_report)){
                                header('Location: ../alert_msg/reset_done.php');
                            }
                        }
                    }else{
                        header('Location: ../alert_msg/reset_invalid.php');
                    }

                }else{
                    header('Location: ../alert_msg/page_not_found.php');
                }
            }
        }
    ?>
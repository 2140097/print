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
                        if(isset($_POST['id_to_reset'])){
                            $id_to_set_tokens = $_POST['id_to_reset'];
                        }
                        if(isset($_POST['id_to_reset'])){
                            $tokens = $_POST['token_set'];
                        }
                            $sql3 = "UPDATE clients SET tokens = '$tokens' WHERE idnum = '$id_to_set_tokens'";
                            if($conn->query($sql3)){
                                $is_reset = true;
                            }else{
                                echo 'database broken';
                            }
                        }else{
                            header('Location: ../alert_msg/reset_invalid.php');
                        }

                        if($is_reset = true){
                            $date = date("Y-m-d");
                            $details = "tokens were reset for user ".$id_to_set_tokens;
                            $sql_report = "INSERT INTO reports (report_num, date, details) VALUES ('0', '$date', '$details')";
                            if($conn->query($sql_report)){
                                header('Location: ../alert_msg/tokens_set.php');
                            }
                        }
                    }else{
                        header('Location: ../alert_msg/reset_invalid.php');
                    }

                }else{
                    header('Location: ../alert_msg/reset_invalid.php');
                }
            }
    ?>
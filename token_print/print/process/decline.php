<?php
    
    session_start();
?>
<html>
    <div>
        <?php
            include '../includes/dbh.php';
            $requestnum = $_GET['requestnum'];
            $sql = "UPDATE prnt_request SET status='declined' WHERE request_no='$requestnum'";
            if($conn->query($sql)){
                header('Location: ../pages/listrequest.php');
            }else{
                echo "failed";
            }
        ?>
    </div>
</html>
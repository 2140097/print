<?php

    session_start();

    include '../includes/dbh.php';

    if(isset($_GET['requestnum'])) 
    {

    $requestnum    = $_GET['requestnum'];
    $sql = "SELECT filename, filetype, filesize, content " .
            "FROM prnt_request WHERE request_no = '$requestnum'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $filename = $row['filename'];
            $filetype = $row['filetype'];
            $filesize = $row['filesize'];
            $content = $row['content'];
         }
    }
    

    header("Content-length: $filesize");
    header("Content-type: $filetype");
    header("Content-Disposition: attachment; filename=$filename");
    echo $content;
    exit;
}

?>
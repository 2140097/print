<?php
    session_start();
	if(isset($_SESSION['uid']) && isset($_SESSION['auth'])){
		$session_auth = $_SESSION['auth'];
		if($session_auth == 'client'){
			//do nothing
		}else {
			header('Location: ../alert_msg/page_not_found.php');
		}
	}else {
		header('Location: ../alert_msg/page_not_found.php');
	}

    include '../includes/dbh.php';
    if(isset($_POST['upload']) && $_FILES['uploadfile']['size'] > 0){
        
        $filename = $_FILES['uploadfile']['name'];
        $tmpname  = $_FILES['uploadfile']['tmp_name'];
        $filesize = $_FILES['uploadfile']['size'];
        $filetype = $_FILES['uploadfile']['type'];

        if (
            !isset($_FILES['uploadfile']['error']) ||
            is_array($_FILES['uploadfile']['error'])
        ) {
            header('Location: ../alert_msg/invalid_parameters.php');
        }

        //check filesize. 
        if ($_FILES['uploadfile']['size'] > 1000000) {
            header('Location: ../alert_msg/invalid_filesize.php');
        }

        // Check $_FILES['uploadfile']['error'] value.
        switch ($_FILES['uploadfile']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                header('Location: ../alert_msg/no_file.php');
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                header('Location: ../alert_msg/invalid_filesize.php');
                break;
            default:
                header('Location: ../alert_msg/file_error.php');
                break;
        }

        //check filetype
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES['uploadfile']['tmp_name']),
            array(
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'pdf' => 'application/pdf',
                'ppt' => 'application/vnd.ms-powerpoint',
                'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'xls' => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'txt' => 'text/plain',
                ),
                true
        )) {
            header('Location: ../alert_msg/invalid_file_format.php');
        }else{
            
            /**echo "filename: " . $filename . "</br>";
            echo "filesize: " . $filesize . "</br>";
            echo "filetype: " . $filetype . "</br></br></br>";**/

            $fp      = fopen($tmpname, 'r');
            $content = fread($fp, filesize($tmpname));
            $content = addslashes($content);
            fclose($fp);

            //sql
            if(isset($_SESSION['uid'])){
                $uid = $_SESSION['uid'];
                $sql = "SELECT * FROM clients WHERE uid='$uid'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $name = $row['name'];
                        $idnum = $row['idnum'];
                    }
                }

                $date = date("Y-m-d");

                $laboratory = $_POST['laboratory'];

                $sql2 = "INSERT INTO prnt_request (request_no, date, idnum, filename, filetype, filesize, content, status, laboratory) 
                        VALUES ('0', '$date', '$idnum', '$filename', '$filetype', '$filesize', '$content', 'pending', '$laboratory')";
                if($conn->query($sql2)){
                    header('Location: ../alert_msg/request_added.php');
                }else{
                    header('Location: ../alert_msg/request_failed.php');
                }
                
            }

        }
    }else{
        header('Location: ../alert_msg/no_file.php');
    }
?>
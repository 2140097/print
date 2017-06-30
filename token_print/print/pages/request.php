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

?>

<html>
<head>
    <title>print request</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>

<body>
    <?php
        include '../includes/nav.php';
    ?>
    <div id="prnt_request_box">
		<h1>Print Request</h1>
		<img src="">
		<div id="requestbox">
            <form method="post" enctype="multipart/form-data" action="../process/upload.php">
                <input name="uploadfile" type="file" id="uploadfile">
				<br>
				<label>Printing Laboratory:</label>
				<br>
				<select name="laboratory" required>
					<option value='S326'>S326</option>
					<option value='S422'>S422</option>
				</select> 
                <input name="upload" type="submit" id="upload" value="Upload">
            </form>
		</div>
	</div>
</body>

</html>
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
?>

<html>
<head>
    <title>Add user</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>

<body>
    <?php
        include '../includes/nav.php';
    ?>
    <div id="adduser_box">
		<h1>Add user</h1>
		<img src="">
		<div id="upload_csv">
            <form action="../process/uploadcsv.php" method="POST" enctype="multipart/form-data">
                <label>import csv file</label><br>
                <input type=file name="csvfile" id='file_box'>
                <input type="submit" name="uploadcsv" id='submit_csv_btn'>
            </form>
		</div>
        <div id="add_user">
            <form action="../process/addusers.php" method="POST" enctype="multipart/form-data">
                <label>add new user</label><br>
                <div>
                    <input type=text name="firstname" placeholder="firstname" required>
                    <input type="text" name="lastname" placeholder="lastname">
                </div>
                <div>
                    <input type="text" name="idnum" placeholder="idnumber">
                </div>
                <div>
                    <input type="text" name="username" placeholder="username"><br>
                    <input type="text" name="password" placeholder="password"><br>
                    <select name="acctype">
                        <option selected disabled>--type--</option>
                        <option value="graduate">graduate</option>
                        <option value="undergraduate">undergraduate</option>
                    </select>
                    <input type="submit" value="Add">
                </div>
            </form>
		</div>
        <a href='../pages/userlist.php' id='cancelbtn'>cancel</a>
	</div>
</body>
</html>
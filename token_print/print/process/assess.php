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
    <title>Assessment</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>

<body>
    <header>
        <?php
            include '../includes/nav.php';
        ?>
    </header>
    <div id="assessment_box">
	<h1>Assessment</h1>
    <div id='assessment_details'>
        <?php

            include '../includes/dbh.php';

            if(isset($_GET['requestnum'])){
                $requestno = $_GET['requestnum'];
                $sql = "SELECT * FROM prnt_request NATURAL JOIN clients where request_no='$requestno' ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $filename = $row['filename'];
                        $filetype = $row['filetype'];
                        $filesize = $row['filesize'];
                        $idnum = $row['idnum'];
                        $name = $row['name'];
                        $tokens = $row['tokens'];
                    }
                    echo "<label>from: </label>" . $name . "<br>";
                    echo "<label>ID number: </label>" . $idnum . "<br>";
                    echo "<label>filename: </label>" . $filename . "<br>";
                    echo "<label>filetype: </label>" . $filetype . "<br>";
                    echo "<label>filesize: </label>" . $filesize/1000 . " KB (" . $filesize . " bytes)<br>";
                    echo "<label>tokens left: </label>" . $tokens;
                } else {
                echo "invalid search";
                }

            }

            ?>
        </div>
		<div id="manual_assessment">
            <span>manual assessment</span>
            <form method="POST" action="manual_assess.php">
                <div id="fields">
                    <input type="hidden" name="requestnum" value="<?php echo $requestno; ?>">
                    <input type="number" placeholder="tokens consumed" name="deduction" required>
                </div>
                <input type="submit" value="submit" id="submitbtn">
            </form>
		</div>
        <!-- alternative assessment -->
        <div id="automated_assessment">
            <span>automated assessment</span><br><br>
            <form method="POST" action="">
                <div id="fields">
                    <label>number of pages</label><br>
                    <input type="number" name="pages"><br><br>

                    <label>number of black and white pages</label><br>
                    <input type="number" name="colored_pages"><br><br>

                    <label>number of colored pages</label><br>
                    <input type="number" placeholder="" name="colored_pages"><br><br>

                    <label>number of black and white image pages</label><br>
                    <input type="number" name="image_pages"><br><br>

                    <label>number of colored image pages</label><br>
                    <input type="number" placeholder="" name="colored_image_pages"><br><br>
                </div>
                <input type="submit" value="submit" id="submitbtn">
            </form>
		</div>
        <div id="backdiv">
            <a href="../pages/listrequest.php" id="">cancel</a>
        <div>
	</div>
</body>
</html>
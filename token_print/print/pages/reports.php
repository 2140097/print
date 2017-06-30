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
    <titlerequest list</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>

<body>
    <?php
        include '../includes/nav.php';
    ?>
	<div id='userlist_box'>
		<h1>Reports</h1>
    <table id="request_table">
    <?php
        
        if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
	}

    include '../includes/dbh.php';

	$sql = "SELECT * FROM reports";
	
	//query from database and assign result to variable result
	$result = $conn->query($sql);
	
	//num_rows checks if there are more than zero rows returned
	if ($result->num_rows > 0) {
		// fetch_assoc() puts all the results into an associative array
		
		echo "
				<tr>

				<th>
					number
				</th>
				
				<th>
					date
				</th>
				
				<th>
					details
				</th>
				

                </tr>

                ";
				
		while($row = $result->fetch_assoc()){  
		echo "<tr><td>" .  $row['report_num']
			. "</td><td>" . $row['date']
			. "</td><td>" . $row['details']
			. "</td></tr>";
		}
		
		echo "</table>";
		
	} else {
    echo "0 results";
	}

    ?>
	</div>
</body>

</html>
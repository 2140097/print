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
    <div id="listrequest_box">
		<h1>Request List</h1>


    <table id="request_table">
    <?php
        
        if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
	}

    include '../includes/dbh.php';

	$sql_1 = "SELECT * FROM prnt_request WHERE (status='declined')";

	$result_1= $conn->query($sql_1);

	if($result_1->num_rows > 0){
		while($row_1 = $result_1->fetch_assoc()){
			$closed_request_no = $row_1['request_no'];
			$closed_request_date = $row_1['date'];
			$closed_request_idnum = $row_1['idnum'];
			$closed_request_filename = $row_1['filename'];
			$closed_request_status = $row_1['status'];

			$sql_2 = "INSERT INTO closed_request (request_no, date, idnum, filename, status) VALUES ('$closed_request_no','$closed_request_date','$closed_request_idnum','$closed_request_filename','$closed_request_status')";

			$conn->query($sql_2);

			$sql_3 = "DELETE FROM prnt_request WHERE request_no='$closed_request_no'";

			$conn->query($sql_3);
		}
	}

	$sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE status='pending'";
	if(isset($_GET['sort'])){
		if($_GET['sort'] == 'rn'){
			$sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE status='pending' ORDER BY request_no";
		}else if($_GET['sort'] == 'dt'){
			$sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE status='pending' ORDER BY date";
		}else if($_GET['sort'] == 'id'){
			$sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE status='pending' ORDER BY idnum";
		}else if($_GET['sort'] == 'nm'){
			$sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE status='pending' ORDER BY name";
		}else if($_GET['sort'] == 'fn'){
			$sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE status='pending' ORDER BY filename";
		}else if($_GET['sort'] == 'lab'){
			$sql = "SELECT * FROM prnt_request NATURAL JOIN clients WHERE status='pending' ORDER BY laboratory";
		}
	}
	//query from database and assign result to variable result
	$result = $conn->query($sql);
	
	//num_rows checks if there are more than zero rows returned
	if ($result->num_rows > 0) {
		// fetch_assoc() puts all the results into an associative array
		
		echo "
				<tr>

				<th>
					<a href='listrequest.php?sort=rn'>Request number</a>
				</th>
				
				<th>
					<a href='listrequest.php?sort=dt'>Date</a>
				</th>
				
				<th>
					<a href='listrequest.php?sort=id'>ID number</a>
				</th>
				
				<th>
					<a href='listrequest.php?sort=nm'>Name</a>
				</th>
				
				<th>
					<a href='listrequest.php?sort=fn'>Content</a>
				</th>

				<th>
					<a href='listrequest.php?sort=lab'>Laboratory</a>
				</th>
				
				<th>
					Status
				</th>

				<th>
					Assessment
				</th>
			    
                </tr>

                ";
				
		while($row = $result->fetch_assoc()){  
        $filename = $row['filename'];
		echo "<tr><td>" .  $row['request_no']
			. "</td><td>" . $row['date']
			. "</td><td>" . $row['idnum']
			. "</td><td>" . $row['name'] 
			. "</td><td>" . "<a href=" . '"../process/download.php?requestnum='. $row['request_no'] .'">' . $filename . "</a>"
			. "</td><td>" . $row['laboratory']
			. "</td><td>" . $row['status']
			. "</td><td>" . "<a href='../process/assess.php?requestnum=". $row['request_no'] ."'" ." id='processbtn'><img src=../images/accept.png height=30 width=30></a>"
			. "<a href='../process/decline.php?requestnum=". $row['request_no'] ."'" ." id='processbtn'><img src=../images/decline.png height=30 width=30></a>"
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
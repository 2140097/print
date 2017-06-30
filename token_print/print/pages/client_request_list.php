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
    <titlerequest list</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../includes/style.css" />
</head>

<body>
    <?php
        include '../includes/nav.php';
    ?>
    <div id="client_print_list">
		<h1>Request List</h1>

    <table id="request_table">
    <?php
        
    if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
	}

    include '../includes/dbh.php';

        $sql1 = "SELECT * FROM clients WHERE uid='$uid'";
        $result1 = $conn->query($sql1);
        if($result1->num_rows > 0){
            while($row1 = $result1->fetch_assoc()){
                $idnum = $row1['idnum'];
            }
        }

        //get requests
        $sql = "SELECT * FROM prnt_request WHERE idnum='$idnum'";
        
        //query from database and assign result to variable result
        $result = $conn->query($sql);
        
        //num_rows checks if there are more than zero rows returned
        if ($result->num_rows > 0) {
            // fetch_assoc() puts all the results into an associative array
            
            echo "
                    <tr>

                    <th>
                        Request number
                    </th>
                    
                    <th>
                        Date
                    </th>
                    
                    <th>
                        Content
                    </th>

                    <th>
                        Laboratory
                    </th>

                    ";
                    
            while($row = $result->fetch_assoc()){  
            $filename = $row['filename'];
            echo "<tr><td>" .  $row['request_no']
                . "</td><td>" . $row['date']
                . "</td><td>" . "<a href=" . '"../process/download.php?requestnum='. $row['request_no'] .'">' . $filename . "</a>"
                . "</td><td>" . $row['laboratory']
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
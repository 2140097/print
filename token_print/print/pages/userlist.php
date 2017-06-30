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
		<h1>User List</h1>
        <div id="userlistmenu">
            <a href="adduser.php" id='add_user'>Add user</a>
            <a href="../process/reset.php" id='reset_tokens'>Reset Tokens</a>
            <a href="../process/delete_list.php" id='delete_list'>Delete list</a>
        </div>
	
    <table id="request_table">
    <?php
        
        if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
	}

    include '../includes/dbh.php';

	$sql = "SELECT * FROM users NATURAL JOIN clients WHERE auth='client'";

	if(isset($_GET['sort'])){
		if($_GET['sort'] == 'id'){
			$sql = $sql." ORDER BY idnum";
		}else if($_GET['sort'] == 'nm'){
			$sql = $sql." ORDER BY name";
		}else if($_GET['sort'] == 'tkn'){
			$sql = $sql." ORDER BY tokens";
		}else if($_GET['sort'] == 'typ'){
			$sql = $sql." ORDER BY type";
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
					<a href='userlist.php?sort=id'>ID number</a>
				</th>
				
				<th>
					<a href='userlist.php?sort=nm'>Name</a>
				</th>
				
				<th>
					<a href='userlist.php?sort=tkn'>tokens</a>
				</th>
				
				<th>
					<a href='userlist.php?sort=typ'>type</a>
				</th>

			    <th></th>

				<th></th>

                </tr>

                ";
				
		while($row = $result->fetch_assoc()){  
		echo "<tr><td>" .  $row['idnum']
			. "</td><td>" . $row['name']
			. "</td><td>" . $row['tokens']
			. "</td><td>" . $row['type']
            . "</td><td>" . "<a href='../process/set_tokens.php?token_set_num=".$row['idnum']."'>set tokens</a>"
			. "</td><td>" . "<a href='../process/delete_user.php?user_delete_num=".$row['idnum']."'>delete</a>"
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
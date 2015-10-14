<?php

$pw = 'your_password';

$connection = new mysqli('localhost', 'your_username',$pw,'your_db_name',0,'your_socket');

if ($connection) {
	$sql = "SELECT * FROM labels WHERE approved='y' ORDER BY `name` ASC";
	if ($result = $connection->query($sql)) {
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$myArray[] = $row;
	    }
		echo json_encode($myArray);
	}
	else {
		echo "There are no labels in the database";
	}
}
else {
	echo "nope";
	die("Connection failed: " . $conn->connect_error);
}

$connection->close();

?>
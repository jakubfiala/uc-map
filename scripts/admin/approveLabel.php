<?php

$label = $_POST['label'];

$connection = new mysqli('localhost', 'your_username','your_password','your_db_name',0,'your_socket');
$sql = "UPDATE `labels` SET `approved`='y' WHERE `index`='".$label."'";
//$sql = "SELECT * FROM labels ORDER BY `name` ASC";
if ($result = $connection->query($sql)) {
	echo $result;
}
else {
	echo "0";
}

?>
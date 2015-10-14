<?php

$pw = $_GET['pw'];
$labelsToApprove = array();

if ($pw == 'your_other_password') {
	$connection = new mysqli('localhost', 'your_username','your_password','your_db_name',0,'your_socket');
	$sql = "SELECT * FROM labels ORDER BY `name` ASC";
	//$sql = "SELECT * FROM labels ORDER BY `name` ASC";
	if ($result = $connection->query($sql)) {
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$labelsToApprove[] = $row;
	    }
	}
	else {
		echo "There are no labels in the database";
	}
}
else {
	echo 'The gates of Moria stand still.';
}

?>

<!DOCTYPE HTML>
<html>
<head>
	<title>United Cassettes Admin Utility</title>
	<style type="text/css">
		body {
			font-size: 11px;
		}

		table {
			width: 100%;
		}

		table, td, tr {
			border: 1px solid black;
		}

		tr:first-child {
			background: gray;
			color: white;
			font-size: 12px;
		}
	</style>
</head>
<body>
	<table>
		<tr>
			<td>name</td>
			<td>address</td>
			<td>latitude</td>
			<td>longitude</td>
			<td>genres</td>
			<td>description</td>
			<td>website</td>
			<td>bandcamp</td>
			<td>fb</td>
			<td>ig</td>
			<td>tw</td>
			<td>mail</td>
		</tr>
		<?php
			foreach($labelsToApprove as $label) {
				echo '<tr>';
				foreach ($label as $data) {
					echo '<td>'.$data.'</td>';
				}
				echo '<td><button title="'.$label['index'].'">Remove '.$label['name'].'</button></td>';
				echo '</tr>';
			}
		?>
	</table>
	<script type="text/javascript">
		var buttons = document.getElementsByTagName('button');
		buttons = Array.prototype.slice.call(buttons, 0);
		buttons.forEach(function(button, index, array) {
			button.addEventListener('click',function() {
				var http = new XMLHttpRequest();
				var url = "removeLabel.php";
				var params = "label=" + button.getAttribute('title');
				http.open("POST", url, true);

				//Send the proper header information along with the request
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.setRequestHeader("Content-length", params.length);
				http.setRequestHeader("Connection", "close");

				http.onreadystatechange = function() {//Call a function when the state changes.
				    if(http.readyState == 4 && http.status == 200) {
				        if (http.responseText == "0") {
				        	alert("Could not approve label");
				        }
				        else {
				        	button.parentElement.parentElement.style.display = "none";
				        }
				    }
				}
				http.send(params);
			},false);
		});
	</script>
</body>
</html>
<?php

$p = $_GET['pineapple'];

if ($p = 'yes')
	$shall_we_make_juice = true;

$loc_sql = "SELECT loc, COUNT(*) as frequency
		FROM labels
		WHERE approved='y'
		GROUP BY loc
		ORDER BY COUNT(*) DESC;";

$genre_sql = "SELECT genre FROM labels WHERE approved='y'";

$pw = 'your_password';

$connection = new mysqli('localhost', 'your_username',$pw,'your_db_name',0,'your_socket');

if ($connection) {

	//GET LOCATIONS
	if ($loc_result = $connection->query($loc_sql)) {
		while($row = $loc_result->fetch_array(MYSQL_ASSOC)) {
			$locArray[] = $row;
	    }
	}
	else {
		echo "There are no locations in the database";
	}

	//GET GENRES
	if ($genre_result = $connection->query($genre_sql)) {
		while($row = $genre_result->fetch_array(MYSQL_ASSOC)) {
			$genreArray[] = $row;
	    }

	    $genres = array();

	    foreach ($genreArray as $genreObj) {
	    	$genres = array_merge($genres, explode(",", $genreObj["genre"]));
	    }

	    $counts = array_count_values($genres);
	    arsort($counts);
	    $genresOut = array_keys($counts);
	}
	else {
		echo "There are no locations in the database";
	}

	$output["locs"] = $locArray;
	$output["genres"] = $genresOut;

	echo json_encode($output);

}
else {
	echo "nope";
	die("Connection failed: " . $conn->connect_error);
}

$connection->close();


?>
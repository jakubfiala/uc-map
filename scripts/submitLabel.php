<?php

$APIKEY = 'your_gmaps_apikey';

//parse POST data
//we'll get the stupid &gt; because design is super important
//so let's get rid of it, if it's there
$name = $_POST['name'][0] == '>' ? substr($_POST['name'],2) : $_POST['name'];
$loc = $_POST['loc'][0] == '>' ? substr($_POST['loc'],2) : $_POST['loc'];
$lat = $_POST['lat'][0] == '>' ? substr($_POST['lat'],2) : $_POST['lat'];
$lng = $_POST['lng'][0] == '>' ? substr($_POST['lng'],2) : $_POST['lng'];
$genres = $_POST['genre'][0] == '>' ? substr($_POST['genre'],2) : $_POST['genre'];
$descr = $_POST['descr'][0] == '>' ? substr($_POST['descr'],2) : $_POST['descr'];
$web = $_POST['web'][0] == '>' ? substr($_POST['web'],2) : $_POST['web'];
$bc = $_POST['bc'][0] == '>' ? substr($_POST['bc'],2) : $_POST['bc'];
$fb = $_POST['fb'][0] == '>' ? substr($_POST['fb'],2) : $_POST['fb'];
$ig = $_POST['ig'][0] == '>' ? substr($_POST['ig'],2) : $_POST['ig'];
$tw = $_POST['tw'][0] == '>' ? substr($_POST['tw'],2) : $_POST['tw'];
$mail = $_POST['mail'][0] == '>' ? substr($_POST['mail'],2) : $_POST['mail'];

//process genres
$g_exploded = explode(",", $genres);
foreach ($g_exploded as $g) {
	//some people put spaces after commas (correctly)
	if ($g[0] == ' ') $g = substr($g, 1);
	//convert to lowercase (should consult with Filip)
	$g = strtolower($g);
	$g_resultArray[] = $g;
}
//join up the first 3 genres only
$g_result = implode(",", array_slice($g_resultArray, 0, 3));

//process social links
/*if (!strpos($web, 'http://') && !strpos($web, 'https://')) {
	$web = 'http://'.$web;
}
if (!strpos($bc, 'http://') && !strpos($bc, 'https://')) {
	$bc = 'http://'.$bc;
}
if (!strpos($fb, 'http://') && !strpos($fb, 'https://')) {
	$fb = 'http://'.$fb;
}*/

//process address
//$address_lookup = str_replace(" ", "+", $address);

//get geocoding data to find out coords
/*$json_geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address_lookup.'&key='.$APIKEY);
$decoded_json_geo = json_decode($json_geo);
$lat = $decoded_json_geo->results[1]->geometry->location->lat;
$lng = $decoded_json_geo->results[1]->geometry->location->lng;
if (!$lat || !$lng) {
	$lat = 0.0;
	$lng = 0.0;
}*/

$pw = 'your_password';

$connection = new mysqli('localhost', 'your_username',$pw,'your_db_name',0,'your_socket');

if ($connection) {
	$size_sql = "SELECT COUNT(*) FROM `labels`";
	if ($response1 = $connection->query($size_sql)) {
		while($row = $response1->fetch_array(MYSQL_ASSOC)) {
			$count[] = $row;
	    }
		$save_sql = "INSERT INTO `labels`(`index`,`name`, `loc`, `lat`, `lng`, `genre`, `descr`, `website`, `bc`, `fb`, `ig`, `tw`, `mail`) VALUES ('".$count[0]["COUNT(*)"]."','".$name."','".$loc."',".$lat.",".$lng.",'".$g_result."','".$descr."','".$web."','".$bc."','".$fb."','".$ig."','".$tw."','".$mail."')";
		if ($response2 = $connection->query($save_sql))
			echo $response2;
		else
			echo "fuck";
	}
	else {
		echo "problem";
	}

}
else {
	echo "nope";
}

$connection->close();

//save data to db

?>
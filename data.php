<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
	header("Content-type:application/json;charset=utf-8");
	header('Content-Disposition: filename="data.json"');

	$dbhost = 'localhost';
	$dbname = 'database';
	$dbuser = 'database_user';
	$dbpass = 'database_password';

	try {

		$dbcon = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
		$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch (Exception $e) {
		die($e->getMessage());
	}

	$stmt=$dbcon->prepare("SELECT `date_time`, `temp`, `dp`, `rh` FROM `table` ORDER BY `date_time` DESC LIMIT 24");
	$stmt->execute();
	$json = [];
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
    	$json[]=[$date_time, $rh, $temp, $dp];
	}

	echo json_encode($json);
?>

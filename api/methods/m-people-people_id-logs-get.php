<?php
$route = '/people/:people_id/logs/';
$app->get($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM profile_log al";
	$Query .= " WHERE al.Profile_ID = " . $people_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$log_id = $Database['Profile_Log_ID'];
		$details = $Database['Details'];
		$details = scrub($details);

		$type = $Database['Type'];
		$log_date = $Database['Log_Date'];

		$log_id = prepareIdOut($log_id,$host);

		$F = array();
		$F['log_id'] = $log_id;
		$F['type'] = $type;
		$F['details'] = $details;
		$F['log_date'] = $log_date;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

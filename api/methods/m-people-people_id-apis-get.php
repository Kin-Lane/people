<?php
$route = '/people/:people_id/apis/';
$app->get($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

	$Query = "SELECT a.API_ID,a.Name FROM api a";
	$Query .= " JOIN profile_api_pivot cap ON a.API_ID = cap.API_ID";
	$Query .= " WHERE cap.Profile_ID = " . $people_id;
	//echo $Query . "<br />";
	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$api_id = $Database['API_ID'];
		$name = $Database['Name'];

		$api_id = prepareIdOut($api_id,$host);
		
		$F = array();
		$F['api_id'] = $api_id;
		$F['name'] = $name;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>

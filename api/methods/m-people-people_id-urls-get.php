<?php
$route = '/people/:people_id/urls/';
$app->get($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * from profile_url cn";
	$Query .= " WHERE cn.Profile_ID = " . $people_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$url_ID = $Database['Profile_URL_ID'];
		$type = $Database['Type'];
		$url = $Database['URL'];
		$name = $Database['Name'];

		$url_id = prepareIdOut($url_id,$host);

		$F = array();
		$F['url_id'] = $url_ID;
		$F['type'] = $type;
		$F['url'] = $url;
		$F['name'] = $name;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

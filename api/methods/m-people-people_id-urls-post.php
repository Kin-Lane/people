<?php
$route = '/people/:people_id/urls/';
$app->post($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['type']) && isset($param['url']))
		{

		$type = trim(mysql_real_escape_string($param['type']));
		$url = trim(mysql_real_escape_string($param['url']));
		$name = trim(mysql_real_escape_string($param['name']));

		$query = "INSERT INTO profile_url(Profile_ID,Type,URL,Name) VALUES(" . $people_id . ",'" . $type . "','" . $url . "','" . $name . "')";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$url_id = mysql_insert_id();

		$url_id = prepareIdOut($url_id,$host);

		$F = array();
		$F['url_id'] = $url_id;
		$F['type'] = $type;
		$F['url'] = $url;
		$F['name'] = $name;

		array_push($ReturnObject, $F);

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

<?php
$route = '/people/:people_id/apis/:api_id';
$app->delete($route, function ($people_id,$api_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);
	$api_id = prepareIdIn($api_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	$DeleteQuery = "DELETE FROM profile_api_pivot WHERE API_ID = " . $api_id . " AND Profile_ID = " . $people_id;
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$api_id = prepareIdOut($api_id,$host);
	$people_id = prepareIdOut($people_id,$host);

	$F = array();
	$F['api_id'] = $api_id;
	$F['people_id'] = $people_id;

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>

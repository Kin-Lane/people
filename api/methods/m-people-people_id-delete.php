<?php
$route = '/people/:people_id/';
$app->delete($route, function ($people_id) use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$Add = 1;
	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	$query = "DELETE FROM profile WHERE ID = " . $people_id;
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());

	$people_id = prepareIdOut($people_id,$host);

	$F = array();
	$F['people_id'] = $people_id;

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>

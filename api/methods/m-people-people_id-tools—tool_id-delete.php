<?php
$route = '/people/:people_id/tools/:tool_id';
$app->delete($route, function ($people_id,$tool_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);
	$tool_id = prepareIdIn($tool_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	$DeleteQuery = "DELETE FROM profile_tool_pivot WHERE Tools_ID = " . $tool_id . " AND Profile_ID = " . $people_id;
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$people_id = prepareIdOut($people_id,$host);
	$tool_id = prepareIdOut($tool_id,$host);

	$F = array();
	$F['people_id'] = $people_id;
	$F['tools_id'] = $tool_id;
	$F['url'] = '';

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>

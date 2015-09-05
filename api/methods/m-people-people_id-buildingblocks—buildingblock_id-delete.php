<?php
$route = '/people/:people_id/buildingblocks/:building_block_id';
$app->delete($route, function ($people_id,$building_block_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);
	$building_block_id = prepareIdIn($building_block_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	$DeleteQuery = "DELETE FROM profile_building_block_pivot WHERE Building_Block_ID = " . $building_block_id . " AND Profile_ID = " . $people_id;
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$building_block_id = prepareIdOut($building_block_id,$host);
	$people_id = prepareIdOut($people_id,$host);

	$F = array();
	$F['building_block_id'] = $building_block_id;
	$F['people_id'] = $people_id;
	$F['url'] = $url;

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>

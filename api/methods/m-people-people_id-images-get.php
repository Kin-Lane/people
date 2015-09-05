<?php
$route = '/people/:people_id/images/';
$app->get($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * from profile_image ai";
	$Query .= " WHERE ai.Profile_ID = " . $people_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$image_id = $Database['Profile_Image_ID'];
		$type = $Database['Type'];
		$path = $Database['Image_Path'];
		$name = $Database['Image_Name'];

		$image_id = prepareIdOut($image_id,$host);

		$F = array();
		$F['image_id'] = $image_id;
		$F['type'] = $type;
		$F['path'] = $path;
		$F['name'] = $name;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

<?php
$route = '/people/:people_id/buildingblocks/';
$app->get($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

	$Query = "SELECT bb.Building_Block_ID,abbp.Profile_ID,abbp.Tools_ID,abbp.URL,bb.Name,bb.About,bb.Sort_Order,bbc.Name as Building_Block_Category FROM building_block bb";
	$Query .= " JOIN profile_building_block_pivot abbp ON bb.Building_Block_ID = abbp.Building_Block_ID";
	$Query .= " JOIN building_block_category bbc ON bb.Building_Block_Category_ID = bbc.BuildingBlockCategory_ID";
	$Query .= " WHERE abbp.Profile_ID = " . $people_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$building_block_id = $Database['Building_Block_ID'];
		$people_id = $Database['Profile_ID'];
		$tools_id = $Database['Tools_ID'];
		$url = $Database['URL'];
		$name = $Database['Name'];
		$about = $Database['About'];

		$pattern = '/[^\w ]+/';
		$replacement = '';
		$about = preg_replace($pattern, $replacement, $about);

		$building_block_category = $Database['Building_Block_Category'];
		$url = $Database['Sort_Order'];

		$building_block_id = prepareIdOut($building_block_id,$host);
		$people_id = prepareIdOut($people_id,$host);
		$tools_id = prepareIdOut($tools_id,$host);

		$F = array();
		$F['buildingblock_id'] = $building_block_id;
		$F['people_id'] = $people_id;
		$F['tools_id'] = $tools_id;
		$F['url'] = $url;
		$F['name'] = $name;
		$F['about'] = $about;
		$F['building_block_category'] = $building_block_category;
		$F['url'] = $url;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

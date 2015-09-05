<?php
$route = '/people/:people_id/apis/';
$app->post($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	if(isset($people_id) && isset($param['api_id']))
		{

		$api_id = trim(mysql_real_escape_string($param['api_id']));

		$CheckTagQuery = "SELECT API_ID FROM profile_api_pivot WHERE API_ID = " . $api_id . " AND Profile_ID = " . $people_id;
		//echo $CheckTagQuery . "<br />";
		$CheckTagResults = mysql_query($CheckTagQuery) or die('Query failed: ' . mysql_error());
		if($CheckTagResults && mysql_num_rows($CheckTagResults))
			{
			$API = mysql_fetch_assoc($CheckTagResults);
			}
		else
			{

			$query = "INSERT INTO profile_api_pivot(API_ID,Profile_ID) VALUES(" . $api_id . "," . $people_id . ")";
			//echo $query . "<br />";
			mysql_query($query) or die('Query failed: ' . mysql_error());
			}

		$api_id = prepareIdOut($api_id,$host);
		$people_id = prepareIdOut($people_id,$host);

		$F = array();
		$F['api_id'] = $api_id;
		$F['people_id'] = $people_id;

		array_push($ReturnObject, $F);

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

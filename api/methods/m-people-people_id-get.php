<?php
$route = '/people/:people_id/';
$app->get($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM profile WHERE ID = " . $people_id;
	//echo $Query . "<br />";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$people_id = $Database['Profile_ID'];
		$full_name = $Database['Full_Name'];
		$first_name = $Database['First_Name'];
		$last_name = $Database['Last_Name'];
		$email = $Database['Email'];
		$location = $Database['Location'];
		$bio = $Database['Bio'];
		$bio = scrub($bio);
		$ranking = $Database['Ranking'];
		$photo = $Database['Photo'];
		$company = $Database['Company'];

		// manipulation zone

		$people_id = prepareIdOut($people_id,$host);

		$F = array();
		$F['people_id'] = $people_id;
		$F['full_name'] = $full_name;
		$F['first_name'] = $first_name;
		$F['last_name'] = $last_name;
		$F['email'] = $email;
		$F['location'] = $location;
		$F['bio'] = $bio;
		$F['ranking'] = $ranking;
		$F['photo'] = $photo;
		$F['company'] = $company;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

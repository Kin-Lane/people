<?php
$route = '/people/:people_id/';
$app->put($route, function ($people_id) use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['full_name'])){ $full_name = trim(mysql_real_escape_string($param['full_name'])); } else { $full_name = 'No Name'; }
	if(isset($param['first_name'])){ $first_name = trim(mysql_real_escape_string($param['first_name'])); } else { $first_name = 'No'; }
	if(isset($param['last_name'])){ $last_name = trim(mysql_real_escape_string($param['last_name'])); } else { $last_name = 'Name'; }
	if(isset($param['email'])){ $email = trim(mysql_real_escape_string($param['email'])); } else { $email = ''; }
	if(isset($param['location'])){ $location = trim(mysql_real_escape_string($param['location'])); } else { $location = ''; }
	if(isset($param['bio'])){ $bio = trim(mysql_real_escape_string($param['bio'])); } else { $bio = ''; }
	if(isset($param['ranking'])){ $ranking = trim(mysql_real_escape_string($param['ranking'])); } else { $ranking = 7; }
	if(isset($param['photo'])){ $photo = trim(mysql_real_escape_string($param['photo'])); } else { $photo = ''; }
	if(isset($param['company'])){ $company = trim(mysql_real_escape_string($param['company'])); } else { $company = ''; }

	$post_date = date('Y-m-d H:i:s');

  	$Query = "SELECT * FROM profile WHERE ID = " . $people_id;
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());

	if($Database && mysql_num_rows($Database))
		{

		$Company = mysql_fetch_assoc($Database);
		$post_date = $Company['Post_Date'];

		$query = "UPDATE profile SET";

		if($full_name!='') { $query .= " Full_Name = '" . mysql_real_escape_string($full_name) . "'"; }
		if($first_name!='') { $query .= ", First_Name = '" . mysql_real_escape_string($first_name) . "'"; }
		if($last_name!='') { $query .= ", Last_Name = '" . mysql_real_escape_string($last_name) . "'"; }
		if($email!='') { $query .= ", Email = '" . mysql_real_escape_string($email) . "'"; }
		if($location!='') { $query .= ", Location = '" . mysql_real_escape_string($location) . "'"; }
		if($bio!='') { $query .= ", Bio = '" . mysql_real_escape_string($bio) . "'"; }
		if($ranking!='') { $query .= ", Ranking = '" . mysql_real_escape_string($ranking) . "'"; }
		if($photo!='') { $query .= ", Photo = '" . mysql_real_escape_string($photo) . "'"; }
		if($company!='') { $query .= ", Company = '" . mysql_real_escape_string($company) . "'"; }

		$query .= " WHERE ID = " . $people_id;

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		}

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

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>

<?php
$route = '/people/';
$app->post($route, function () use ($app){

	$Add = 1;
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
	$people_id = 0;

  	$Query = "SELECT * FROM profile WHERE Full_Name LIKE '%" . $full_name . "%'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());

	if($Database && mysql_num_rows($Database))
		{
		$ThisItem = mysql_fetch_assoc($Database);
		}
	else
		{
		$Query = "INSERT INTO profile(";
		$Query .= "Full_Name,";
		$Query .= "Post_Date,";

		if($first_name!='') { $Query .= "First_Name,"; }
		if($last_name!='') { $Query .= "Last_Name,"; }
		if($email!='') { $Query .= "Email,"; }
		if($location!='') { $Query .= "Location,"; }
		if($bio!='') { $Query .= "Bio,"; }
		if($ranking!='') { $Query .= "Ranking,"; }
		if($photo!='') { $Query .= "Photo,"; }
		if($company!='') { $Query .= "Company,"; }

		$Query .= "Closing";
		$Query .= ") VALUES(";
		$Query .= "'" . mysql_real_escape_string($full_name) . "',";
		$Query .= "'" . mysql_real_escape_string($post_date) . "',";

		if($first_name!='') { $Query .= "'" . mysql_real_escape_string($first_name) . "',"; }
		if($last_name!='') { $Query .= "'" . mysql_real_escape_string($last_name) . "',"; }
		if($email!='') { $Query .= "'" . mysql_real_escape_string($email) . "',"; }
		if($location!='') { $Query .= "'" . mysql_real_escape_string($location) . "',"; }
		if($bio!='') { $Query .= "'" . mysql_real_escape_string($bio) . "',"; }
		if($ranking!='') { $Query .= "'" . mysql_real_escape_string($ranking) . "',"; }
		if($photo!='') { $Query .= "'" . mysql_real_escape_string($photo) . "',"; }
		if($company!='') { $Query .= "'" . mysql_real_escape_string($company) . "',"; }

		$Query .= "'nothing'";

		$Query .= ")";

		//echo $Query . "<br />";
		mysql_query($Query) or die('Query failed: ' . mysql_error());
		$people_id = mysql_insert_id();
		}

	$host = $_SERVER['HTTP_HOST'];
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

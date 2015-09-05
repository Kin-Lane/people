<?php
$route = '/people/:people_id/notes/';
$app->get($route, function ($people_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);

	$ReturnObject = array();

	$Query = "SELECT ID,Profile_ID,Type,Note From profile_notes cn";
	$Query .= " WHERE cn.Profile_ID = " . $people_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$note_id = $Database['ID'];
		$Type = $Database['Type'];
		$Note = $Database['Note'];

		$note_id = prepareIdOut($note_id,$host);

		$F = array();
		$F['note_id'] = $note_id;
		$F['type'] = $Type;
		$F['note'] = $Note;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>

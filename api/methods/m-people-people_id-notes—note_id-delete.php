<?php
$route = '/people/:people_id/notes/:note_id';
$app->delete($route, function ($people_id,$note_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$people_id = prepareIdIn($people_id,$host);
	$note_id = prepareIdIn($note_id,$host);

	$ReturnObject = array();

	$DeleteQuery = "DELETE FROM profile_notes WHERE ID = " . $note_id;
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$note_id = prepareIdOut($note_id,$host);

	$F = array();
	$F['note_id'] = $note_id;
	$F['type'] = '';
	$F['note'] = '';

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>

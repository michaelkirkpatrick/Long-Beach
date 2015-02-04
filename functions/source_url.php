<?
function source_url($source_url, $mysqli){
	$db_source_url = $mysqli->real_escape_string($source_url);
	$query = "SELECT source FROM sources WHERE source_url='$db_source_url'";
	$result = $mysqli->query($query);
	$array = $result->fetch_array(MYSQLI_ASSOC);
	return $array['source'];
}
?>
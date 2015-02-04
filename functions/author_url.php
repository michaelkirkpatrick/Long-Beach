<?
function author_url($author_url, $mysqli){
	$db_author_url = $mysqli->real_escape_string($author_url);
	$query = "SELECT author FROM authors WHERE author_url='$db_author_url'";
	$result = $mysqli->query($query);
	$array = $result->fetch_array(MYSQLI_ASSOC);
	return $array['author'];
}
?>
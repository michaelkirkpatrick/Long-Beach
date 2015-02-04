<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/css/notional.css" type="text/css" media="screen" />
  <title>Database Update</title>
</head>
<body>
<div id="container">
<h1>Database Update</h1>
<?
// Required Files
require_once('../common/dbconnect.php');
require_once('../functions/clean_url.php');

$query = "SELECT DISTINCT author FROM blog ORDER BY author ASC";
$result = $mysqli->query($query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	
	// Author
	$author = $row['author'];
	
	// Query Table
	$db_author_name = $mysqli->real_escape_string($author);
	$authors_query = "SELECT id FROM authors WHERE author='$db_author_name'";
	$authors_result = $mysqli->query($authors_query);
	
	// Does Author exist?
	if($authors_result->num_rows == 0){
		
		// Convert to URL
		$author_url = clean_url($author);
		$db_author_url = $mysqli->real_escape_string($author_url);
		
		// Insert Query
		$author_insert_query = "INSERT INTO authors (author_url, author) VALUES ('$db_author_url', '$db_author_name')";
		$mysqli->query($author_insert_query);
		
		// Output HTML
		echo '<p>Author <strong>' . $author . '</strong> added to Authors table.</p>' . "\n";
	}
}

$query = "SELECT DISTINCT source FROM blog ORDER BY source ASC";
$result = $mysqli->query($query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){

	// Source
	$source = $row['source'];
	
	// Query Table
	$db_source_name = $mysqli->real_escape_string($source);
	$sources_query = "SELECT id FROM sources WHERE source='$db_source_name'";
	$sources_result = $mysqli->query($sources_query);
	
	// Does source exist?
	if($sources_result->num_rows == 0 && $source !=''){
		
		// Convert to URL
		$source_url = clean_url($source);
		$db_source_url = $mysqli->real_escape_string($source_url);
		
		// Insert Query
		$source_insert_query = "INSERT INTO sources (source_url, source) VALUES ('$db_source_url', '$db_source_name')";
		$mysqli->query($source_insert_query);
		
		// Output HTML
		echo '<p>source <strong>' . $source . '</strong> added to sources table.</p>' . "\n";
	}
}

// Output HTML
echo '<p><strong>Done with database updates</strong>.</p>' . "\n";
echo '<p>Let\'s update the <a href="generate-sitemap.php">sitemap</a></p>' . "\n";
?>
</div>
</body>
</html>
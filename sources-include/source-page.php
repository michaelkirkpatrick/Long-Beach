<?
// Breadcrumb
echo '<p class="breadcrumb"><a href="/">Blog</a> &raquo; <a href="/source/">Sources</a> &raquo; ' . $source . '</p>' . "\n";

// Query
$current_time = time();
$source_query = "SELECT title, author, published_time, url, published_month, published_year FROM blog WHERE source='$source' AND published_time<$current_time";
$source_result = $mysqli->query($source_query);

// Header
echo '<h1>Articles from ' . $source . '</h1>' . "\n";

// Show all Results
while($row = $source_result->fetch_array(MYSQLI_ASSOC)){
	
	// Parse Data
	$date_display = date('F j, Y', $row['published_time']);
	$title_display = $row['title'];
	$author = $row['author'];
	$url = $row['url'];
	$year = $row['published_year'];
	$month = $row['published_month'];
	
	// Output HTML
	echo '    <div class="article" itemscope itemtype="http://schema.org/Article">' . "\n";

	// Get URLs
	require_once('functions/clean_url.php');
	$author_url = clean_url($row['author']);
	
	// Article Title
	require_once('functions/article_title.php');
	echo article_title('', $title_display, $year, $month, $url, TRUE, 'permalink');
	
	// Attribution
	require_once('functions/attribution.php');
	echo attribution($author_url, $author, $source_url, $source, $date_display, $year, $month, $url, FALSE, TRUE, FALSE) ;
	
	echo '</div>' . "\n";

}
?>
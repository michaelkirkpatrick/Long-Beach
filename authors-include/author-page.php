<?
// Breadcrumb
echo '<p class="breadcrumb"><a href="/">Blog</a> &raquo; <a href="/author/">Authors</a> &raquo; ' . $author . '</p>' . "\n";

// Query
$current_time = time();
$author_query = "SELECT title, source, published_time, url, published_month, published_year FROM blog WHERE author='$author' AND published_time<$current_time ORDER BY published_time DESC";
$author_result = $mysqli->query($author_query);

// Header
echo '<h1>Articles by ' . $author . '</h1>' . "\n";

// Show all Results
while($row = $author_result->fetch_array(MYSQLI_ASSOC)){
	
	// Parse Data
	$date_display = date('F j, Y', $row['published_time']);
	$title_display = $row['title'];
	$source_display = $row['source'];
	$url = $row['url'];
	$year = $row['published_year'];
	$month = $row['published_month'];
	
	// Output HTML
	echo '    <div class="article" itemscope itemtype="http://schema.org/Article">' . "\n";

	// Get URLs
	require_once('functions/clean_url.php');
	$source_url = clean_url($row['source']);
	
	// Article Title
	require_once('functions/article_title.php');
	echo article_title('', $title_display, $year, $month, $url, TRUE, 'permalink');
	
	// Attribution
	require_once('functions/attribution.php');
	echo attribution($author_url, $author, $source_url, $source_display, $date_display, $year, $month, $url, FALSE, FALSE, TRUE) ;
	
	echo '</div>' . "\n";

}
?>
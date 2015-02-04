<?
// Breadcrumb
require_once('functions/month.php');
echo '<p class="breadcrumb"><a href="/">Blog</a> &raquo; ' . $year . '</p>' . "\n";

// Header
echo '<h1>' . $year . ' Articles</h1>';

// Month Array
require_once('functions/month.php');

// Month Save
$month_save = '';

// Get all the article ID's for this year
$current_time = time();
$year_query = "SELECT title, author, source, published_time, text, url, published_month FROM blog WHERE published_year='$year' AND published_time<$current_time ORDER BY published_time ASC";
$year_result = $mysqli->query($year_query);

while($row = $year_result->fetch_array(MYSQLI_ASSOC)){
	
	// Output Month HTML
	$month_display = $row['published_month'];
	if($month_display != $month_save){
		echo '<h2><a href="/' . $year . '/' . $month_display . '/">' . month($month_display) . '</a></h2>';
		//echo '<p class="archives-month"><a href="/' . $year . '/' . $month_display . '/">' . month($month_display) . '</a></p>';
		$month_save = $month_display;
	}
	
	// Parse Data
	$date_display = date('F jS', $row['published_time']);
	$title_display = SmartyPants($row['title']);
	$author_display = htmlspecialchars($row['author']);
	$source_display = htmlspecialchars($row['source']);
	$url = $row['url'];
	$month = $month_display;
	$text_display = SmartyPants(Markdown($row['text']));
		
	// Get URLs
	require_once('functions/clean_url.php');
	$author_url = clean_url($row['author']);
	$source_url = clean_url($row['source']);
		
	// Output HTML
	echo '    <div itemscope itemtype="http://schema.org/Article">' . "\n";
	
	// Article Title
	require_once('functions/article_title.php');
	echo article_title('', $title_display, $year, $month, $url, TRUE, 'permalink');
	
	// Attribution
	require_once('functions/attribution.php');
	echo attribution($author_url, $author_display, $source_url, $source_display, $date_display, $year, $month, $url, FALSE, TRUE, TRUE) ;
  	
	echo '</div>' . "\n";

}
?>
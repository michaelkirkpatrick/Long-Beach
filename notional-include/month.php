<?
// Breadcrumb
require_once('functions/month.php');
echo '<p class="breadcrumb"><a href="/">Blog</a> &raquo; <a href="/' . $year  . '/">' . $year . '</a> &raquo; ' . month($month) . '</p>' . "\n";

// Header
echo '<h1>' . month($month) . ' Articles</h1>';

// Get all the article ID's for this month
$current_time = time();
$month_query = "SELECT title, author, source, published_time, text, url FROM blog WHERE published_month='$month' AND published_year='$year' AND published_time<$current_time ORDER BY published_time ASC";
$month_result = $mysqli->query($month_query);

while($row = $month_result->fetch_array(MYSQLI_ASSOC)){
			
	// Parse Data
	$date_display = date('F jS', $row['published_time']);
	$title_display = SmartyPants($row['title']);
	$author_display = htmlspecialchars($row['author']);
	$source_display = htmlspecialchars($row['source']);
	$url = $row['url'];
	$text_display = SmartyPants(Markdown($row['text']));
		
	// Get URLs
	require_once('functions/clean_url.php');
	$author_url = clean_url($row['author']);
	$source_url = clean_url($row['source']);
		
	// Output HTML
	echo '    <div class="article" itemscope itemtype="http://schema.org/Article">' . "\n";
	
	// Article Title
	require_once('functions/article_title.php');
	echo article_title('', $title_display, $year, $month, $url, FALSE, 'permalink');
	
	// Attribution
	require_once('functions/attribution.php');
	echo attribution($author_url, $author_display, $source_url, $source_display, $date_display, $year, $month, $url, FALSE, TRUE, TRUE) ;
  
	// Article Body	
	echo '<div itemprop="articleBody">' . $text_display . '</div>' . "\n";
	
	echo '</div>' . "\n";
}
?>
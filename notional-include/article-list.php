<?
// Display All Articles

// Only items that have been published
// (No posts scheduled for the future)
$post_cutoff_time = time();

// How many articles to display?
$num_articles = 10;

$query = "SELECT published_time, link, title, author, source, url, text, published_month, published_year FROM blog WHERE published_time<$post_cutoff_time ORDER BY published_time DESC LIMIT $num_articles";
$result = $mysqli->query($query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	// Parse Data
	$date_display = date('l, F jS', $row['published_time']);
	$link = $row['link'];
	$title_display = SmartyPants($row['title']);
	$author_display = htmlspecialchars($row['author']);
	$source_display = htmlspecialchars($row['source']);
	$url = $row['url'];
	$text_display = SmartyPants(Markdown($row['text']));
	$month = $row['published_month'];
	$year = $row['published_year'];
	
	// Get Author URL
	require_once('functions/clean_url.php');
	$author_url = clean_url($row['author']);
	$source_url = clean_url($row['source']);

	// Output HTML
	echo '    <div class="article" itemscope itemtype="http://schema.org/Article">' . "\n";
	
	// Article Title
	require_once('functions/article_title.php');
	echo article_title($link, $title_display, $year, $month, $url, FALSE, 'article-list');
	
	// Attribution
	require_once('functions/attribution.php');
	echo attribution($author_url, $author_display, $source_url, $source_display, $date_display, $year, $month, $url, TRUE, TRUE, TRUE) ;
	
	// Article Text
	echo '<div itemprop="articleBody">' . $text_display . '</div>' . "\n";
  
	// Closing HTML
	echo '    </div>' . "\n";
	echo '<div class="article-gap"></div>' . "\n";
}

// Display Archives
include('common/archives.php');
?>
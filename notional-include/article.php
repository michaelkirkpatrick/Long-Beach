<?
// Article - Time Check
$time_query = "SELECT published_time FROM blog WHERE url='$article_url'";
$time_result = $mysqli->query($time_query);
$time_row = $time_result->fetch_array(MYSQLI_ASSOC);
$num_results = $time_result->num_rows; // Ensure article exists

if($num_results > 0 && $time_row['published_time'] < time()){
  
	// Data Query
	$article_query = "SELECT published_time, link, title, author, source, url, text FROM blog WHERE url='$article_url'";
	$article_result = $mysqli->query($article_query);
	$article_array = $article_result->fetch_array(MYSQLI_ASSOC);
	
	// Breadcrumb
	require_once('functions/month.php');
	echo '<p class="breadcrumb"><a href="/">Blog</a> &raquo; <a href="/' . $year  . '/">' . $year . '</a> &raquo; <a href="/' . $year . '/' . $month . '/">' . month($month) . '</a> &raquo; ' . $article_array['title'] . '</p>' . "\n";
	
	// Parse Data
	$date_display = date('F j, Y', $article_array['published_time']);
	$link = $article_array['link'];
	$title_display = SmartyPants($article_array['title']);
	$author_display = $article_array['author'];
	$source_display = $article_array['source'];
	$url = $article_array['url'];
	$text_display = SmartyPants(Markdown($article_array['text']));
  
	// Get URLs
	require_once('functions/clean_url.php');
	$author_url = clean_url($article_array['author']);
	$source_url = clean_url($article_array['source']);
  
	// Output HTML
	echo '    <div class="article" itemscope itemtype="http://schema.org/Article">' . "\n";
	
	// Article Title
	require_once('functions/article_title.php');
	echo article_title($link, $title_display, $year, $month, $url, FALSE, 'article');
	
	// Attribution
	require_once('functions/attribution.php');
	echo attribution($author_url, $author_display, $source_url, $source_display, $date_display, $year, $month, $url, FALSE, TRUE, TRUE) ;
  
	// Article Body	
	echo '<div class="instapaper_body" itemprop="articleBody">' . $text_display . '</div>' . "\n";
	
	echo '</div>' . "\n";

}else{
  // 404 Error - Not Published (Yet)
}
?>
<?
$prefix = $_SERVER['DOCUMENT_ROOT'];
require_once($prefix . '/common/markdown.php');
require_once($prefix . '/common/smartypants.php');

// Connect to Database
include('common/dbconnect.php');

// Only items that have been published
// (No posts scheduled for the future)
$post_cutoff_time = time();

// Number of Posts
$num_of_posts = 14;

// Troubleshoot?
$troubleshoot = FALSE;

// Last Updated
$last_updated_query = "SELECT MAX(published_time) AS last_update FROM blog WHERE published_time<$post_cutoff_time";
$last_updated_result = $mysqli->query($last_updated_query);
$last_updated_array = $last_updated_result->fetch_array(MYSQLI_ASSOC);
$last_updated_timestamp = $last_updated_array['last_update'];
$last_updated = date('c', $last_updated_timestamp);

// Preamble
if(!$troubleshoot){
	echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
	echo '<feed xmlns="http://www.w3.org/2005/Atom">' . "\n";
}
echo '<title>MEK Studios</title>' . "\n";
echo '<id>tag:www.mekstudios.com,2013-02-10:/notional/20130210055031443</id>' . "\n";
echo '<subtitle type="html">Critical thinking to start your day.&lt;br>A blog of ideas, thoughts, and concepts for consideration.</subtitle>' . "\n";
echo '<link rel="alternate" type="text/html" hreflang="en" href="https://www.mekstudios.com/"/>' . "\n";
echo '<link rel="self" type="application/atom+xml" href="https://www.mekstudios.com/feed/"/>' . "\n";
echo '<rights>Copyright (c) 2013 Michael E. Kirkpatrick</rights>' . "\n";
echo '<updated>' . $last_updated . '</updated>' . "\n";
echo '<author>' . "\n";
echo '  <name>Michael E. Kirkpatrick</name>' . "\n";
echo '  <uri>http://www.mekstudios.com</uri>' . "\n";
echo '  <email>michael@mekstudios.com</email>' . "\n";
echo '</author>' . "\n";

// Cycle through posts
$article_query = "SELECT url, link, title, author, published_time, published_month, published_year, updated_time, text, atom_id FROM blog WHERE published_time<$post_cutoff_time ORDER BY published_time DESC LIMIT $num_of_posts";
$article_result = $mysqli->query($article_query);
while($article_array = $article_result->fetch_array(MYSQLI_ASSOC)){
	echo '<entry>' . "\n";
	//echo '  <title type="html">' . htmlspecialchars(html_entity_decode($article_array['title'], ENT_QUOTES | ENT_HTML5, "UTF-8")) . '</title>' . "\n";
	echo '  <title type="html">' . htmlspecialchars(SmartyPants($article_array['title'], ENT_QUOTES | ENT_HTML5, "UTF-8")) . '</title>' . "\n";
	echo '  <id>' . $article_array['atom_id'] . '</id>' . "\n";
	if($article_array['link'] != ''){echo '  <link href="' . htmlspecialchars($article_array['link']) . '" rel="via" type="text/html" />' . "\n";}
	echo '  <link href="http://www.mekstudios.com/' . $article_array['published_year'] . '/' . $article_array['published_month'] . '/' . $article_array['url'] . '" rel="alternate" type="text/html" />' . "\n";
	echo '  <published>' . date('c', $article_array['published_time']) . '</published>' . "\n";
	# If Updated
	if($article_array['updated_time'] != ''){
		echo '  <updated>' . date('c', $article_array['updated_time']) . '</updated>' . "\n";
	}else{
		echo '  <updated>' . date('c', $article_array['published_time']) . '</updated>' . "\n";
	}
	echo '  <author>' . "\n";
	echo '    <name>' . $article_array['author'] . '</name>' . "\n";
	echo '  </author>' . "\n";
	
	$text_display = SmartyPants(Markdown($article_array['text']));
	//$text_display = html_entity_decode($article_array['text'], ENT_QUOTES | ENT_HTML5, "UTF-8");
	//$text_display = str_replace('\r\n', '', $text_display);
	$find = array('&', '<');
	$replace = array('&amp;', '&lt;');
	$text_display = str_replace($find, $replace, $text_display);
	echo '  <content type="html">' . $text_display . '</content>' . "\n";
	echo '</entry>' . "\n";
}

// End of Feed
echo '</feed>' . "\n";
?>
<?
// Connect to Database
include('../common/dbconnect.php');

// Path to File
$sitemap_path = '../sitemap.xml';

// Preamble
$sitemap_xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$sitemap_xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Current time
$current_time = time();

/* --- (1) Top Level Pages ---*/

$rel_directory = '../';
$prefix = 'https://www.mekstudios.com';

// (1A) Homepage

$mod_time_query = "SELECT MAX(published_time) AS latest_update FROM blog WHERE published_time<'$current_time'";
$mod_time_result = $mysqli->query($mod_time_query);
$mod_time_array = $mod_time_result->fetch_array(MYSQLI_ASSOC);
$latest_post = date('c', $mod_time_array['latest_update']);

$sitemap_xml .= '<url>' . "\n";
$sitemap_xml .= '  <loc>' . $prefix . '</loc>' . "\n";
$sitemap_xml .= '  <lastmod>' . $latest_post . '</lastmod>' . "\n";
$sitemap_xml .= '  <changefreq>daily</changefreq>' . "\n";
$sitemap_xml .= '  <priority>1.0</priority>' . "\n";
$sitemap_xml .= '</url>' . "\n";

// (1A Cont.) Other Pages

$sitemap_xml .= '<url>' . "\n";
$sitemap_xml .= '  <loc>' . $prefix . '/privacy/</loc>' . "\n";
$last_mod = strtotime('February 3, 2015 8:40 PM', time());
$sitemap_xml .= '  <lastmod>' . date('c', $last_mod) . '</lastmod>' . "\n";
$sitemap_xml .= '  <changefreq>yearly</changefreq>' . "\n";
$sitemap_xml .= '  <priority>0.5</priority>' . "\n";
$sitemap_xml .= '</url>' . "\n";

$sitemap_xml .= '<url>' . "\n";
$sitemap_xml .= '  <loc>' . $prefix . '/about/</loc>' . "\n";
$last_mod = strtotime('February 3, 2015 9:15 PM', time());
$sitemap_xml .= '  <lastmod>' . date('c', $last_mod) . '</lastmod>' . "\n";
$sitemap_xml .= '  <changefreq>monthly</changefreq>' . "\n";
$sitemap_xml .= '  <priority>1.0</priority>' . "\n";
$sitemap_xml .= '</url>' . "\n";

// (1B) Authors Page

$mod_time_query = "SELECT MAX(date_added) AS latest_update FROM authors";
$mod_time_result = $mysqli->query($mod_time_query);
$mod_time_array = $mod_time_result->fetch_array(MYSQLI_ASSOC);
$latest_author = date('c', $mod_time_array['latest_update']);

$sitemap_xml .= '<url>' . "\n";
$sitemap_xml .= '  <loc>' . $prefix . '/author/</loc>' . "\n";
$sitemap_xml .= '  <lastmod>' . $latest_author . '</lastmod>' . "\n";
$sitemap_xml .= '  <changefreq>monthly</changefreq>' . "\n";
$sitemap_xml .= '  <priority>0.3</priority>' . "\n";
$sitemap_xml .= '</url>' . "\n";

// (1C) Sources Page
	
$mod_time_query = "SELECT MAX(date_added) AS latest_update FROM sources";
$mod_time_result = $mysqli->query($mod_time_query);
$mod_time_array = $mod_time_result->fetch_array(MYSQLI_ASSOC);
$latest_source = date('c', $mod_time_array['latest_update']);

$sitemap_xml .= '<url>' . "\n";
$sitemap_xml .= '  <loc>' . $prefix . '/source/</loc>' . "\n";
$sitemap_xml .= '  <lastmod>' . $latest_source . '</lastmod>' . "\n";
$sitemap_xml .= '  <changefreq>monthly</changefreq>' . "\n";
$sitemap_xml .= '  <priority>0.3</priority>' . "\n";
$sitemap_xml .= '</url>' . "\n";

// (1D) Year and Month Pages

$archives_year_query = "SELECT DISTINCT published_year FROM blog WHERE published_time<'$current_time' ORDER BY published_year DESC";
$archives_year_result = $mysqli->query($archives_year_query);
while($row = $archives_year_result->fetch_array(MYSQLI_ASSOC)){
	// Parse Variables
	$year = $row['published_year'];
	
	// Latest Update this Year
	$max_year_query = "SELECT MAX(published_time) AS LatestUpdate FROM blog WHERE published_year='$year' AND  published_time<'$current_time'";
	$max_year_result = $mysqli->query($max_year_query);
	$max_year_array = $max_year_result->fetch_array(MYSQLI_ASSOC);
	$max_year_update = date('c', $max_year_array['LatestUpdate']);
	
	// Year Priority
	if(date('Y', $current_time) == $year){
		$change_freq = 'monthly';
	}else{
		$change_freq = 'never';
	}
	
	// Echo sitemap data
	$sitemap_xml .= '<url>' . "\n";
	$sitemap_xml .= '  <loc>' . $prefix . '/' . $year . '/</loc>' . "\n";
	$sitemap_xml .= '  <lastmod>' . $max_year_update . '</lastmod>' . "\n";
	$sitemap_xml .= '  <changefreq>' . $change_freq . '</changefreq>' . "\n";
	$sitemap_xml .= '  <priority>0.1</priority>' . "\n";
	$sitemap_xml .= '</url>' . "\n";
	
	// Months
	$archives_month_query = "SELECT DISTINCT published_month FROM blog WHERE published_year='$year' AND  published_time<'$current_time' ORDER BY published_month ASC";
	$archives_month_result = $mysqli->query($archives_month_query);
	while($archives_month_array = $archives_month_result->fetch_array(MYSQLI_ASSOC)){
	  
	  	// Month
	  	$month = $archives_month_array['published_month'];
	  
		// Latest Update this Month
		$max_month_query = "SELECT MAX(published_time) AS LatestUpdate FROM blog WHERE published_year='$year' AND published_month='$month' AND published_time<'$current_time'";
		$max_month_result = $mysqli->query($max_month_query);
		$max_month_array = $max_month_result->fetch_array(MYSQLI_ASSOC);
		$max_month_update = date('c', $max_month_array['LatestUpdate']);
		
		// Year Priority
		if(date('m', $current_time) == $month){
			$change_freq_mo = 'monthly';
		}else{
			$change_freq_mo = 'never';
		}
		
		// Echo sitemap data
		$sitemap_xml .= '<url>' . "\n";
		$sitemap_xml .= '  <loc>' . $prefix . '/' . $year . '/' . $month . '/</loc>' . "\n";
		$sitemap_xml .= '  <lastmod>' . $max_month_update . '</lastmod>' . "\n";
		$sitemap_xml .= '  <changefreq>' . $change_freq_mo . '</changefreq>' . "\n";
		$sitemap_xml .= '  <priority>0.1</priority>' . "\n";
		$sitemap_xml .= '</url>' . "\n";
	}
}



/* --- (2) Blog Posts --- */

// Article Query
$article_query = "SELECT url, published_time, published_month, published_year, updated_time FROM blog WHERE published_time<'$current_time' ORDER BY published_time";
$article_result = $mysqli->query($article_query);
while($article_array = $article_result->fetch_array(MYSQLI_ASSOC)){

	// Parse Data
	$article_url = $article_array['url'];
	$article_published = $article_array['published_time'];
	$article_updated = $article_array['updated_time'];
	$year = $article_array['published_year'];
	$month = $article_array['published_month'];
	
	// Last Updated
	if($article_updated == ''){
		$updated_time = date('c', $article_published);
	}else{
		$updated_time = date('c', $article_updated);
	}
	
	// Echo Article Data
	$sitemap_xml .= '<url>' . "\n";
	$sitemap_xml .= '  <loc>' . $prefix . '/' . $year . '/' . $month . '/' . $article_url . '</loc>' . "\n";
	$sitemap_xml .= '  <lastmod>' . $updated_time . '</lastmod>' . "\n";
	$sitemap_xml .= '  <priority>0.8</priority>' . "\n";
	$sitemap_xml .= '  <changefreq>never</changefreq>' . "\n";
	$sitemap_xml .= '</url>' . "\n";

}
			

/* --- (3) Authors --- */

$authors_query = "SELECT author_url, latest_update FROM authors ORDER BY id ASC";
$authors_result = $mysqli->query($authors_query);
while($authors_array = $authors_result->fetch_array(MYSQLI_ASSOC)){
	
	$author_url = '/author/' . $authors_array['author_url'];
	$author_last_updated = date('c', $authors_array['latest_update']);
	
	// Echo Authors Data
	$sitemap_xml .= '<url>' . "\n";
	$sitemap_xml .= '  <loc>' . $prefix . $author_url . '</loc>' . "\n";
	$sitemap_xml .= '  <lastmod>' . $author_last_updated . '</lastmod>' . "\n";
	$sitemap_xml .= '  <priority>0.4</priority>' . "\n";
	$sitemap_xml .= '  <changefreq>yearly</changefreq>' . "\n";
	$sitemap_xml .= '</url>' . "\n";
}

// (4) Sources

$sources_query = "SELECT source_url, latest_update FROM sources ORDER BY id ASC";
$sources_result = $mysqli->query($sources_query);
while($sources_array = $sources_result->fetch_array(MYSQLI_ASSOC)){
	
	$source_url = '/source/' . $sources_array['source_url'];
	$source_last_updated = date('c', $sources_array['latest_update']);
	
	// Echo sources Data
	$sitemap_xml .= '<url>' . "\n";
	$sitemap_xml .= '  <loc>' . $prefix . $source_url . '</loc>' . "\n";
	$sitemap_xml .= '  <lastmod>' . $source_last_updated . '</lastmod>' . "\n";
	$sitemap_xml .= '  <priority>0.4</priority>' . "\n";
	$sitemap_xml .= '  <changefreq>yearly</changefreq>' . "\n";
	$sitemap_xml .= '</url>' . "\n";
}

// Close XML
$sitemap_xml .= '</urlset>' . "\n";

// Write to File
$sitemap_filename = '../sitemap.xml';
$file = fopen($sitemap_filename, "w+");
fwrite($file, $sitemap_xml);
fclose($file);

// Echo Success Message
echo '<p><strong>Successfully updated sitemap XML file!</p>';
echo '<p><a href="/">Go to Homepage</a></p>';
?>
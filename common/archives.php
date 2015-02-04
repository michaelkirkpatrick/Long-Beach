<?
// RESOURCE
require_once('functions/month.php');

// Div
echo '<div id="archives">' . "\n";

// Left Links for Alternate Browsing
echo '<div class="archives-column archives-browse">' . "\n";
echo '<p><a href="/author/">Browse by Author</a></p>' . "\n";
echo '<p><a href="/source/">Browse by Source</a></p>' . "\n";
echo '<p><a href="/feed/"><img src="/images/feed-icon.svg" alt="Feed Icon" style="width:1em; margin-right:0.25em" />Feed</a></p>' . "\n";
echo '</div>' . "\n";

// Generate Archives List
$archives_year_query = "SELECT DISTINCT published_year FROM blog ORDER BY published_year DESC";
$archives_year_result = $mysqli->query($archives_year_query);
while($row = $archives_year_result->fetch_array(MYSQLI_ASSOC)){
	// Parse Variables
	$year = $row['published_year'];
	
	// Start Output
	echo '<div class="archives-column">' . "\n";
	echo '<p class="archives-year"><a href="/' . $year . '/">' . $year . '</a></p>' . "\n" . '<ul>' . "\n";
	
	// Months
	$archives_month_query = "SELECT DISTINCT published_month FROM blog WHERE published_year='$year' ORDER BY published_month ASC";
  $archives_month_result = $mysqli->query($archives_month_query);
  while($archives_month_array = $archives_month_result->fetch_array(MYSQLI_ASSOC)){
  
		$month_text = month($archives_month_array['published_month']);
		$month_num = $archives_month_array['published_month'];
		
		echo '<li><a href="/' . $year . '/' . $month_num . '/">' . $month_text . '</a></li>' . "\n";
	}
	
	// End Output
	echo '</ul>' . "\n";
	echo '</div>' . "\n";
}

// Close Div
echo '</div>' . "\n";

?>
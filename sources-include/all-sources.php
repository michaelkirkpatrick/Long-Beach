<?
echo '<p class="breadcrumb"><a href="/">Blog</a> &raquo; Sources</p>' . "\n";

// Unique Query
$unique_query = "SELECT COUNT(DISTINCT source) AS Sources FROM blog";
$unique_result = $mysqli->query($unique_query);
$unique_array = $unique_result->fetch_array(MYSQLI_ASSOC);
$num_tags = $unique_array['Sources'];

// Setup Columns
$num_columns = 3;
$column_width = 100/$num_columns;
if($num_columns == 1){
	$tags_per_column = $num_tags;
}else{
	$tags_per_column = round($num_tags/$num_columns, 0, PHP_ROUND_HALF_UP);
}
$i=1;

// Column Width now in CSS
$new_column = '<div class="column">' . "\n";
$new_column_last = '<div class="column-last">' . "\n";

$column_count = 1;
echo $new_column;
	
// Setup index headings
$current_index = '';
		
// Query Database
$current_time = time();
$query = "SELECT DISTINCT source FROM blog WHERE published_time<$current_time ORDER BY source ASC";
$result = $mysqli->query($query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	
	// Parse Row
	$source = $row['source'];
	
	// Source URL
	require_once('functions/clean_url.php');
	$source_url = clean_url($source);

	// Need index heading?
	require_once('functions/letter_index.php');
	$index = letter_index($source, $current_index);
	if($index['next_index']){
		echo $index['html'];
		$current_index = $index['index'];
	}
	
	// Echo Tag
	echo '<p><a href="/source/' . $source_url . '">' . $source . '</a></p>' . "\n";
	
	// Time for a new column?
	if($i == $tags_per_column){
		echo '</div>' . "\n";
		if($column_count != $num_columns){
			echo $new_column;
		}else{
			echo $new_column_last;
		}
		$i=0;
		$column_count++;
	}
	$i++;
}
echo '</div>';
?>
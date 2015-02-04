<?
echo '<p class="breadcrumb"><a href="/">Blog</a> &raquo; Authors</p>' . "\n";

// Unique Query
$unique_query = "SELECT COUNT(DISTINCT author) AS AuthorName FROM blog";
$unique_result = $mysqli->query($unique_query);
$unique_array = $unique_result->fetch_array(MYSQLI_ASSOC);
$num_tags = $unique_array['AuthorName'];

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
$query = "SELECT DISTINCT author FROM blog WHERE published_time<$current_time ORDER BY author ASC";
$result = $mysqli->query($query);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	
	// Parse Row
	$author = $row['author'];
	
	// Author URL
	require_once('functions/clean_url.php');
	$author_url = clean_url($author);
	
	// Need index heading?
	require_once('functions/letter_index.php');
	$index = letter_index($author, $current_index);
	if($index['next_index']){
		echo $index['html'];
		$current_index = $index['index'];
	}
	
	// Echo Tag
	echo '<p><a href="/author/' . $author_url . '">' . $author . '</a></p>' . "\n";
	
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
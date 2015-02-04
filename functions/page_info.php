<?
function page_info($column, $year, $month, $article_url, $mysqli){
	
	// Published Time
	$time = time();
	
	// Column Adjudication
	if($column == 'year'){
		$db_column = 'published_year';
		$var = $year;
	}elseif($column == 'month'){
		$db_column = 'published_month';
		$var = $month;
	}elseif($column == 'article'){
		$db_column = 'url';
		$var = $article_url;
	}
	
	// Check that var exists
	$db_var = $mysqli->real_escape_string($var);
	$query = "SELECT title FROM blog WHERE $db_column='$db_var' AND published_time<='$time'";
	$result = $mysqli->query($query);
	if($result->num_rows > 0){
		
		// No Error
		$return['error'] = FALSE;
			
		if($column == 'month'){
			
			// Month
			$month_names = array('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December');
			$return['title'] = $month_names[$month] . ' ' . $year . ' Articles - MEK Studios';
			$return['description'] = 'Articles written and linked to in ' . $month_names[$month] . ' ' . $year;
			
		}elseif($column == 'year'){
			
			// Year
			$return['title'] = $var . ' Articles - MEK Studios';
			$return['description'] = 'Articles written and linked to in the year ' . $var;
			
		}elseif($column == 'article'){
			
			// Article
			$array = $result->fetch_array(MYSQLI_ASSOC);
			$return['title'] = htmlspecialchars($array['title']) . ' - MEK Studios';
			
		}
		
	}else{
		$return['error'] = TRUE;
		$return['error_msg'] = 'Value does not exist in the database';
	}
	
	// Return Info
	return $return;
}
?>
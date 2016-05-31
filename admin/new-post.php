<?
# Get URL Parameters
$title = $_GET['title'];

# Set Defaults
$prefix = $_SERVER['DOCUMENT_ROOT'];
require_once($prefix . '/common/markdown.php');
require_once($prefix . '/common/smartypants.php');

function empty_string($variable){
	if($variable == ''){
		return TRUE;
	}else{
		return FALSE;
	}
}

# DEFAULT
$all_accounted_for = TRUE; 

if(isset($_POST['submit'])){
	// Get Variables
	$submit = $_POST['submit'];
	$preview = $_POST['preview'];
	$link = $_POST['link'];
	$title = $_POST['title'];
	$author = $_POST['author'];
	$capitalizeAuthor = $_POST['capitalizeAuthor'];
	$source = $_POST['source'];
	$text = $_POST['text'];
	$post_time = $_POST['post_time'];
	$post_time_later = $_POST['post_time_later'];
	
	// Check for empty strings
	if(empty_string($link)){$link = '';}	# Okay to leave blank
	if(empty_string($title)){$all_accounted_for = FALSE;}
	if(empty_string($author)){$all_accounted_for = FALSE;}
	if(empty_string($source)){$source = '';}	# Okay to leave blank
	if(empty_string($text)){$all_accounted_for = FALSE;}		
	
	// Do we have everything?
	if($all_accounted_for){
	
		// Connect to database
		include($prefix . '/common/dbconnect.php');
		
		// Clean Up Data
		$db_link = $link;
		$db_title = $title;
		$db_author = $author;
		$db_source = $source;
		$db_text = $text;
		
		// Author Name Cleanup
		# We want to know if the Author's name should be in Title Case
		if($capitalizeAuthor == 'capitalize'){
			$author = ucwords(strtolower($author));
		}
		
		// Published Date/Time
		if($post_time == 'now'){
			$db_date = time();
		}elseif($post_time =='later'){
			$db_date = strtotime($post_time_later, time());
			if(!$db_date){$bad_time = TRUE;}
		}
		$db_published_time = $db_date;
		$db_published_month = date('m', $db_date);
		$db_published_year = date('Y', $db_date);
		
		// Convert title to URL
		require_once($prefix . '/functions/clean_url.php');
		$link_url = clean_url($title);
			
		// Check URL for duplicates
		$db_link_url = $mysqli->real_escape_string($link_url);
		$duplicate_url_query = "SELECT url FROM blog WHERE url='$db_link_url'";
		$duplicate_url_result = $mysqli->query($duplicate_url_query);
		$duplicate_url_array = $duplicate_url_result->fetch_array(MYSQLI_ASSOC);
		if($duplicate_url_array['url'] != ''){
			$status_text = '<p style="background-color:red">Duplicate URL - Please Update Title</p>';
		}elseif($bad_time){
			$status_text .= '<p style="background-color:red">Didn\'t understand date</p>';
		}
		else{
			// Generate Atom ID
			$atom_id = 'tag:mekstudios.com,' . date('Y-m-d', $db_published_time) . ':/' . date('Y', $db_published_time) . '/' . date('m', $db_published_time) . '/' . $db_link_url;
			
			// MySQLi Escape
			$db_link = $mysqli->real_escape_string($db_link);
			$db_title = $mysqli->real_escape_string($db_title);
			$db_author = $mysqli->real_escape_string($db_author);
			$db_source = $mysqli->real_escape_string($db_source);
			$db_text = $mysqli->real_escape_string($db_text);
			$db_published_time = $mysqli->real_escape_string($db_published_time);
			$db_published_month = $mysqli->real_escape_string($db_published_month);
			$db_published_year = $mysqli->real_escape_string($db_published_year);
			$db_atom_id = $mysqli->real_escape_string($atom_id);
			
			// Insert Into Blog
			$query = "INSERT INTO blog (link, title, author, source, published_time, published_month, published_year, text, url, atom_id) VALUES ('$db_link', '$db_title', '$db_author', '$db_source', '$db_published_time', '$db_published_month', '$db_published_year', '$db_text', '$db_link_url', '$db_atom_id')";
			if($mysqli->query($query) === TRUE){
				$upload_success = TRUE;
			}
			
			/* --- Update Author's Table --- */
			
			// Query
			$authors_query = "SELECT id FROM authors WHERE author='$db_author'";
			$authors_result = $mysqli->query($authors_query);
			
			// Does Author exist?
			if($authors_result->num_rows == 0){
				
				// Convert to URL
				$author_url = clean_url($author);
				$db_author_url = $mysqli->real_escape_string($author_url);
				
				// Insert Query
				$author_insert_query = "INSERT INTO authors (author_url, author, date_added, latest_update) VALUES ('$db_author_url', '$db_author', '$db_published_time', '$db_published_time')";
				$mysqli->query($author_insert_query);
				
				// Status Message
				$status_text .= '<p>Author <strong>' . $author . '</strong> added to Authors table.</p>' . "\n";
				
			}else{
				
				// Update Latest Article Time
				$author_array = $authors_result->fetch_array(MYSQLI_ASSOC);
				$author_id = $author_array['id'];
				$author_update_query = "UPDATE authors SET latest_update='$db_published_time' WHERE id='$author_id'";
				$mysqli->query($author_update_query);
				
				// Status Message
				$status_text .= '<p>Latest article column updated for <strong>' . $author . '</strong>.</p>' . "\n";
			}
						
			/* --- Update Sources Table --- */
			
			// Query Table
			$sources_query = "SELECT id FROM sources WHERE source='$db_source'";
			$sources_result = $mysqli->query($sources_query);
			
			// Does source exist?
			if($sources_result->num_rows == 0 && $source !=''){
				
				// Convert to URL
				$source_url = clean_url($source);
				$db_source_url = $mysqli->real_escape_string($source_url);
				
				// Insert Query
				$source_insert_query = "INSERT INTO sources (source_url, source, date_added, latest_update) VALUES ('$db_source_url', '$db_source', '$db_published_time', '$db_published_time')";
				$mysqli->query($source_insert_query);
				
				// Output HTML
				$status_text .= '<p>Source <strong>' . $source . '</strong> added to sources table.</p>' . "\n";
			}else{
				
				// Update Latest Article Time
				$source_array = $sources_result->fetch_array(MYSQLI_ASSOC);
				$source_id = $source_array['id'];
				$source_update_query = "UPDATE sources SET latest_update='$db_published_time' WHERE id='$source_id'";
				$mysqli->query($source_update_query);
				
				// Status Message
				$status_text .= '<p>Latest article column updated for <strong>' . $source . '</strong>.</p>' . "\n";
			}
		}
	}
}

?>
<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>New Blog Post</title>
  <link rel="stylesheet" href="../css/notional.css" type="text/css" media="screen" />
  <style>
	.input-text {
		font-size:18px;
		width:450px;
		border:1px solid #C0C0C0;
		border-radius:4px;
		padding:4px;
    font-family:"Courier New", sans-serif;
	}
	.align-right {
		text-align:right;
	}
	.align-top {
		vertical-align:top;
		padding-top:8px;
	}
	.textarea {
		height:400px;
	}
	</style>
  <script>
		function check(){
			document.getElementById("post_time_now").checked = false;
			document.getElementById("post_time_later").checked = true;
		}
	</script>
</head>
<body>
	<div id="container">
  	<h1>New Blog Post</h1>
    <p><a href="/admin/">Admin Home</a> &raquo; New Post</p>
    <?
	if($upload_success){
		
		// Status Message 
		$status_text = '<p style="background-color:green">SUCCESS! Post has been uploaded</p><p><strong><a href="generate-sitemap.php">Let\'s update the sitemap.</a></strong></p>';
		
		// Reset Variables
		unset($link, $title, $author, $source, $date_published, $text);
		
		echo '<h2>Form</h2>';
		
	}elseif(!$all_accounted_for){
		echo '<p style="background-color:red">Oops! Looks like we\'re missing something...</p>';
	}
	
	// Display Status Message
	if(!empty($status_text)){echo $status_text . "\n";}
	?>
    <form method="post">
    	<table>
        <tr>
        	<td class="align-right" valign="top">When to Post:</td>
          	<td>
            	<input type="radio" name="post_time" value="now" checked id="post_time_now" /> Now<br/>
                <input type="radio" name="post_time" value="later" id="post_time_later"/> <input type="text" name="post_time_later" value="<? echo date('F j, Y', time()+60*60*24) . ' 8:00 am'; ?>" class="input-text" onClick="check()" /><br/>
            </td>
        </tr>
      	<tr>
        	<td class="align-right">Link:</td>
          	<td><input type="text" name="link" class="input-text" value="<? echo htmlspecialchars($link); ?>" required autofocus /></td>
        </tr>
        <tr>
        	<td class="align-right">Title:</td>
          	<td><input type="text" name="title" class="input-text" value="<? echo htmlspecialchars($title); ?>" required /></td>
        </tr>
        <tr>
        	<td class="align-right">Author:</td>
          	<td>
                  <input type="text" name="author" class="input-text" value="<? echo htmlspecialchars($author); ?>" placeholder="Michael E. Kirkpatrick" required /><br/>
                  <input type="checkbox" name="capitalizeAuthor" value="capitalize" checked="checked" /> Title case
                </td>
        </tr>
        <tr>
        	<td class="align-right">Source:</td>
          	<td><input type="text" name="source" class="input-text" value="<? echo htmlspecialchars($source); ?>" required /></td>
        </tr>
        <tr>
        	<td class="align-right align-top">HTML Text:</td>
          	<td><textarea class="input-text textarea" name="text"><? echo htmlspecialchars($text); ?></textarea></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
          	<td><input type="submit" name="submit" value="Submit Post" /></td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>

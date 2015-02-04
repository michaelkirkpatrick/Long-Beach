<?
// Connect to database
include('../common/dbconnect.php');

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
	$source = $_POST['source'];
	$text = $_POST['text'];
	$post_id = $_POST['post_id'];
	$pub_date = $_POST['date'];
	$orig_pub_time = $_POST['orig_pub_time'];
	
	// Check for empty strings
	if(empty_string($title)){$all_accounted_for = FALSE;}
	if(empty_string($author)){$all_accounted_for = FALSE;}
	if(empty_string($text)){$all_accounted_for = FALSE;}	
	
	// Do we have everything?
	if($all_accounted_for){
			
		// Date
		$db_updated = time();
		
		$pub_time = strtotime($pub_date);
		$pub_month = date('m', $pub_time);
		$pub_year = date('Y', $pub_time);
		
		if($orig_pub_time != $pub_time){
			$update_pub = ", published_time='$pub_time', published_month='$pub_month', published_year='$pub_year'";
		}else{
			$update_pub = '';
		}
					
		// MySQLi Escape
		$db_link = $mysqli->real_escape_string($link);
		$db_title = $mysqli->real_escape_string($title);
		$db_author = $mysqli->real_escape_string($author);
		$db_source = $mysqli->real_escape_string($source);
		$db_text = $mysqli->real_escape_string($text);
		
		// Update Query
		$query = "UPDATE blog SET link='$db_link', title='$db_title', author='$db_author', source='$db_source', updated_time='$db_updated', text='$db_text' $update_pub WHERE id='$post_id'";
		if($mysqli->query($query) === TRUE){
			$upload_success = TRUE;
		}
	}
}else{
	$update_url = $_GET['url'];
	$db_update_url = $mysqli->real_escape_string($update_url);
	$update_query = "SELECT id, link, title, author, source, text, published_time FROM blog WHERE url='$db_update_url'";
	$update_result = $mysqli->query($update_query);
	$update_array = $update_result->fetch_array(MYSQLI_ASSOC);
	
	$link = $update_array['link'];
	$title = $update_array['title'];
	$author = $update_array['author'];
	$source = $update_array['source'];
	$text = $update_array['text'];
	$pub_time = $update_array['published_time'];
}

?>
<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>Update Post</title>
  <link rel="stylesheet" href="../css/notional.css" type="text/css" media="screen" />
  <style>
	.input-text {
		font-size:18px;
		width:450px;
		border:1px solid #C0C0C0;
		border-radius:4px;
		padding:4px;
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
</head>
<body>
	<div id="container">
  	<h1>Update Post</h1>
    <?
			
		if($upload_success){
			echo '<p style="background-color:green">SUCCESS! Update has been uploaded</p><p><strong><a href="update-list.php">Back to Update List</a></strong></p>';
		}elseif(!$all_accounted_for){
			echo '<p style="background-color:red">Oops! Looks like we\'re missing something...</p>';
		}
		?>
    <form method="post">
    <input type="hidden" name="post_id" value="<? echo $update_array['id']; ?>" />
    <input type="hidden" name="orig_pub_time" value="<? echo $date; ?>" />
    	<table>
        <tr>
        	<td class="align-right">Date:</td>
            <td><input type="text" name="date" class="input-text" value="<? echo date('F j, Y', $pub_time) . ' at ' . date('g:i a', $pub_time); ?>" required /></td>
        </tr>
      	<tr>
        	<td class="align-right">Link:</td>
        	<td><input type="text" name="link" class="input-text" value="<? echo $link; ?>" required autofocus /></td>
        </tr>
        <tr>
        	<td class="align-right">Title:</td>
        	<td><input type="text" name="title" class="input-text" value="<? echo $title; ?>" required /></td>
        </tr>
        <tr>
        	<td class="align-right">Author:</td>
        	<td><input type="text" name="author" class="input-text" value="<? echo $author; ?>" placeholder="Michael E. Kirkpatrick" required /></td>
        </tr>
        <tr>
        	<td class="align-right">Source:</td>
        	<td><input type="text" name="source" class="input-text" value="<? echo $source; ?>" required /></td>
        </tr>
        <tr>
        	<td class="align-right align-top">HTML Text:</td>
        	<td><textarea class="input-text textarea" name="text"><? echo $text; ?></textarea></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        	<td><input type="submit" name="submit" value="Submit Update" /></td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>
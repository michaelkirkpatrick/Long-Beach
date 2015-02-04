<?
// Default
$display_404 = FALSE;

// Get URL Parameters
$author_url = $_GET['url'];

require_once('common/dbconnect.php');

if(empty($author_url)){
	
	// Show all Authors
	$html_include = 'all-authors.php';
	$page_title = 'Authors';
	$page_description = 'Browse the archives of the MEK Studios blog by author.';
	
}else{
	
	// Lookup Author
	require_once('functions/author_url.php');
	$author = author_url($author_url, $mysqli);

	if(empty($author)){
		
		// Author doesn't exist in Database
		header("HTTP/1.1 404 Not Found");
		$display_404 = TRUE;
		$file_404 = 'author';
		
	}else{
		
		// Show Author Page
		$html_include = 'author-page.php';
		$page_title = $author . ' - MEK Studios';
		$page_description = 'Browse posts on MEK Studios authored by ' . $author . '.';
		
	}
}

if($header_404){
	include('error/bad-' . $file_404 . '.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="<? echo $page_description; ?>">
  <? include('common/header-links.php'); ?>
  <title><? echo $page_title; ?></title>
  <style>
	.index {
		font-weight:bold;
	}
	</style>
  <? include('common/google-analytics.php'); ?>
</head>
<body>
  <? include('common/header.php'); ?>
  <div id="container">
    <? 
		include('authors-include/' . $html_include);
    include('common/footer.php');
		?>
  </div>
</body>
</html>
<? } # close if($header_404) ?>
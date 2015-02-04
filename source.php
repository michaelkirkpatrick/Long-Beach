<?
// Default
$display_404 = FALSE;

// Get URL Parameters
$source_url = $_GET['url'];

require_once('common/dbconnect.php');

if(empty($source_url)){
	
	// Show all Sources
	$html_include = 'all-sources.php';
	$page_title = 'Sources';
	$page_description = 'Browse the archives of the MEK Studios blog by source.';
	
}else{

	// Lookup Source
	require_once('functions/source_url.php');
	$source = source_url($source_url, $mysqli);

	if(empty($source)){
		
		// Author doesn't exist in Database
		header("HTTP/1.1 404 Not Found");
		$display_404 = TRUE;
		$file_404 = 'source';
		
	}else{
		
		// Show Source Page
		$html_include = 'source-page.php';
		$page_title = $source . ' - MEK Studios';
		$page_description = 'Browse posts on MEK Studios from ' . $source . '.';
		
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
        include('sources-include/' . $html_include);
        include('common/footer.php');
        ?>
    </div>
</body>
</html>
<? } # close if($header_404) ?>
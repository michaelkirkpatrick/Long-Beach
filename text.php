<?
$prefix = $_SERVER['DOCUMENT_ROOT'];

// Text Cleanup
require_once($prefix . '/common/markdown.php');
require_once($prefix . '/common/smartypants.php');

// Get Page
$page = $_GET['page'];

// Page Title
$page_titles = array('privacy' => 'Privacy Policy', 'about' => 'About');

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><? echo $page_titles[$page]; ?> - MEK Studios</title>
  <? 
	include('common/header-links.php');
	echo "\n";
	include('common/google-analytics.php');
	?>
</head>
<body>
	<? include('common/header.php'); ?>
 	<div id="container">
		<?
		$text = file_get_contents("text/$page.txt"); 
		echo SmartyPants(Markdown($text));
		include('common/footer.php');
		?>
	</div>
</body>
</html>
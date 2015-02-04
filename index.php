<?
$prefix = $_SERVER['DOCUMENT_ROOT'];

// Text Cleanup
require_once($prefix . '/common/markdown.php');
require_once($prefix . '/common/smartypants.php');

// Connect to database
require_once($prefix . '/common/dbconnect.php');

// Default Flags
$error404 = FALSE;

// Get Parameters
$year_requested = $_GET['year'];
$month_requested = $_GET['month'];
$article_requested = $_GET['article'];

// Validate Parameters
preg_match('/\d{4}/', $year_requested, $year_match);
preg_match('/\d{2}/', $month_requested, $month_match);
preg_match('/[a-z0-9-]+/', $article_requested, $article_match);

$year = $year_match[0];
$month = $month_match[0];
$article_url = $article_match[0];

// Page Info
require_once('functions/page_info.php');

// Determine Page to Display
if(empty($year)){
	$page_requested = 'article-list';
	$page_info['title'] = 'MEK Studios';
	$page_info['description'] = 'A blog covering innovation, design, and culture.';
}else{
	if(empty($month)){
			$page_requested = 'year';
			$page_info = page_info('year', $year, $month, $article_url, $mysqli);
		}else{
			if(empty($article_url)){
				$page_requested = 'month';
				$page_info = page_info('month', $year, $month, $article_url, $mysqli);
			}else{
				$page_requested = 'article';
				$page_info = page_info('article', $year, $month, $article_url, $mysqli);
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <? if(!empty($page_info['description'])){echo '<meta name="description" content="' . $page_info['description'] . '">';} ?>
  <title><? echo $page_info['title']; ?></title>
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
    include('notional-include/' . $page_requested . '.php');
		include('common/footer.php');
		?>
	</div>
</body>
</html>
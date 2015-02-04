<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="HTML Error - Article not Found">
  <link rel="stylesheet" href="/css/notional.css" type="text/css" media="screen" />
  <title>Post not Found</title>
  <style>
	.text-center {
		text-align:center;
	}
	img {
		display:block;
		margin:0 auto;
	}
	</style>
</head>
<body>
    <div id="container">
		<? 
        $prefix = $_SERVER['DOCUMENT_ROOT'];
        include($prefix . '/common/header.php');
        ?>
        <img src="/error/sad-face.png" id="sad-face" alt="sad-face" width="100" height="100" />
        <div class="text-center">
          <h1>Article not Found</h1>
          <p>Sorry, I don't seem to have any articles by that title.</p>
          <p><a href="/archives/">Search the Archives</a></p>
        </div>
        <? include($prefix . '/common/footer.php');?>
	</div>
</body>
</html>

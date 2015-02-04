<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="HTML Error - Author not Found">
  <link rel="stylesheet" href="/css/notional.css" type="text/css" media="screen" />
  <title>Author not Found</title>
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
            <h1>Author not Found</h1>
            <p>Sorry, I don't seem to have any articles by that author.</p>
            <p><a href="/author/">Browse all Authors</a></p>
        </div>
        <? include($prefix . '/common/footer.php');?>
	</div>
</body>
</html>

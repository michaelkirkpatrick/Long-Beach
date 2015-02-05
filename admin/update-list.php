<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Update List</title>
  <link rel="stylesheet" href="../css/notional.css" type="text/css" media="screen" />
</head>
<body>
<div id="container">
<h1>Update Posts List</h1>
<p><a href="/admin/">Admin Home</a> &raquo; Update Post</p>
<?
include('../common/dbconnect.php');
$query = "SELECT url, title, published_time FROM blog ORDER BY published_time DESC";
$result = $mysqli->query($query);
echo '<p>' . "\n";
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	echo '' . date('M j, Y', $row['published_time']) . ' &ndash; <a href="/admin/update-post.php?url=' . $row['url'] . '">' . $row['title'] . '</a><br/>' . "\n";
}
echo '</p>' . "\n";
?>
</div>
</body>
</html>
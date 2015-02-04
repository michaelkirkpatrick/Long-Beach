<?
/*
--- Permalink ---
all-authors
author-page
all-sources
source-page
month
year

--- External or Permalink ---
article-list

--- External ---
article

$archives = TRUE / FALSE (determines class)
$link_type = permalink / article-list / article

*/
function article_title($link, $title, $year, $month, $url, $archives, $link_type){	

	// Variables
	$permalink = '/' . $year . '/' . $month . '/' . $url;
	$arrow = '&nbsp;&rarr;';
	
	// Generate Appropriate Link
	if($link_type == 'permalink'){
		$href = $permalink;
		$add = '';
	}elseif($link_type == 'article-list'){
		if(empty($link)){
			$href = $permalink;
			$add = '';
		}else{
			$href = $link;
			$add = $arrow;
		}
	}elseif($link_type == 'article'){
		if(empty($link)){
			$href = '';
			$add = '';
		}else{
			$href = $link;
			$add = $arrow;
		}	
	}
	
	// Which Tag?
	if($archives){
		$tag_open = '<p class="archives-article">';
		$tag_close = '</p>';
	}elseif($link_type == 'permalink' && !$archives){
		$tag_open = '<h2>';
		$tag_close = '</h2>';
	}else{
		$tag_open = '<h1>';
		$tag_close = '</h1>';
	}
	
	// Make title a link?
	if(empty($href)){
		$ahref_open = '';
		$ahref_close = '';
	}else{
		$ahref_open = '<a href="' . $href . '">';
		$ahref_close = '</a>';
	}
	
	return $tag_open . $ahref_open . '<span itemprop="name headline">' . $title . '</span>' . $ahref_close . $add . $tag_close . "\n";
}
?>

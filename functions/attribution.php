<?
function attribution($author_url, $author, $source_url, $source, $date, $year, $month, $url, $permalink, $show_author, $show_source){
	// Start string
	$return = '<p class="article-attribution">';
	
	// Author
	if($show_author){
		$return .= '<a href="/author/' . $author_url . '"><span itemprop="author">' . $author . '</span></a> &middot;';
	}
	
	// Source
	if(!empty($source) && $show_source){
		$return .= ' <a href="/source/' . $source_url . '"><span itemprop="publisher">' . $source . '</span></a> &middot;';
	}
	
	// Date
	$return .= ' <span itemprop="datePublished">' . $date . '</span>';
	
	// Permalink
	if($permalink){
		$return .= '  &middot; <span class="infinity"><a href="/' . $year . '/' . $month . '/' . $url . '" title="Permanent link">&infin;</a></span>';
	}
	
	// Close
	$return .= '</p>' . "\n";
	
	return $return;
}
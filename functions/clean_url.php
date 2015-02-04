<?
function clean_url($url) {
		// Convert ampersand (&) to "and"
    $url = preg_replace("/&/", "and", $url);
		// Convert accented characters
		setlocale(LC_ALL, 'en_US.UTF8');
		$url = iconv('UTF-8', 'ASCII//TRANSLIT', $url);
    // Remove any character that is not alphanumeric, white-space, or a hyphen 
    $url = preg_replace("/[^a-z0-9\s\-]/i", "", $url);
    // Replace multiple instances of white-space with a single space
    $url = preg_replace("/\s\s+/", " ", $url);
    // Replace all spaces with hyphens
    $url = preg_replace("/\s/", "-", $url);
    // Replace multiple hyphens with a single hyphen
    $url = preg_replace("/\-\-+/", "-", $url);
    // Remove leading and trailing hyphens
    $url = preg_replace("/^\-|\-$/", "", $url);
    // Lowercase the URL
    $url = strtolower($url);

    return $url;
}
?>
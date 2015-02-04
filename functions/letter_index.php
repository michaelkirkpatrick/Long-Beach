<?
function letter_index($string, $current_index){
	
	if(preg_match('/^\d/', $string)){
		$index = '#';
	}elseif(preg_match('/^\w/', $string)){
		$index = strtoupper(substr($string, 0, 1));
	}
	
	if($index != $current_index){
		$return['html'] = '<p class="index">' . $index . '</p>' . "\n";
		$return['index'] = $index;
		$return['next_index'] = TRUE;
	}else{
		$return['next_index'] = FALSE;
	}
	
	return $return;
}
?>
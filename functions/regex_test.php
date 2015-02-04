<?
function regex_test($pattern, $value){
  if(preg_match($pattern, $value)){
    return TRUE; 
  }else{
    return FALSE;
  }
}
?>
<?php 
  function strip_empty_script_tags($template){
    $matches = null;
    $contents = file_get_contents($template);
    // Match Script tag
    preg_match("/<script.*?>([^<]*)<\/script>/s", $contents, $matches);
    if(isset($matches[1])){
      $untrimmed_script_contents = $matches[1];
      $script_contents = trim($untrimmed_script_contents, " ");
      // Strip new lines
      $script_contents = str_replace(array("\r", "\n"), '', $script_contents);
      if(strlen($script_contents) <= 0){
        preg_replace("/<script.*?>([^<]*)<\/script>/s","", $contents); 
      }
    }
    return $contents;
  }
?>
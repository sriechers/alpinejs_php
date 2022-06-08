<?php
function format_alpinejs_state_object(array $arr, $sequential_keys = false, $quotes = false, $beautiful_json = false) {

// $output = "{";
$output = "";

$count = 0;
foreach ($arr as $key => $value) {
    if ( isAssoc($arr) || (!isAssoc($arr) && $sequential_keys == true ) ) {

        if(is_array($value)){
            preg_match('/\([^;]*\)/', implode(",", $value), $matches);
        } else {
            preg_match('/\([^;]*\)/', $value, $matches);
        }

        if(count($matches) > 0){
            $output .= ($quotes ? '"' : '') . $key . ($quotes ? '"' : '');
        } else {
            $output .= ($quotes ? '"' : '') . $key . ($quotes ? '"' : '') . ' : ';
        }

    }

    if (is_array($value)) {
        $output .= format_alpinejs_state_object($value, $sequential_keys, $quotes, $beautiful_json);
    } else if (is_bool($value)) {
        $output .= ($value ? 'true' : 'false');
    } else if (is_numeric($value)) {
        $output .= $value;
    } else {
        $output .= ($quotes || $beautiful_json ? '"' : '') . $value . ($quotes || $beautiful_json ? '"' : '');
    }

    if (++$count < count($arr)) {
        $output .= ', ';
    }
}

// $output .= "}";
$output .= "";


return $output;
}

function isAssoc(array $arr) {
  if (array() === $arr) return false;
  return array_keys($arr) !== range(0, count($arr) - 1);
}
?>
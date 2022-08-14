<?php
// Template vor der Ausgabe bearbeiten
ob_start(function ($buffer) use ($options, $_COMPONENT_GROUP_ID) {
  $matches = null;
  $tag_reg_ex = "/(<script.*?>)([^<]*)(<\/script>)/s";

  // preg_match("/<script data-include-twice=\"(.*?)\">/");

  // Komponente wurde bereits geparsed und doppelte Script Tags in Komponenten sind nicht erlaubt
  if (!$options["allow_duplicate_scripts"] && isset($GLOBALS["parsed_components"]) && in_array($_COMPONENT_GROUP_ID, $GLOBALS["parsed_components"])) {
    // Script Tag aus Komponente löschen
    return preg_replace($tag_reg_ex, "", $buffer);
  }

  // Speichern welche Komponenten geparsed wurden
  $GLOBALS["parsed_components"][] = $_COMPONENT_GROUP_ID;

  // Match Script tags
  preg_match($tag_reg_ex, $buffer, $matches);

  $start_tag = $matches[1];
  $end_tag = $matches[3];
  $script_contents = $matches[2];

  $include_only_once = false;
  if ($start_tag) {
    $include_only_once = str_contains($start_tag, "data-include-once");
  }

  if ($include_only_once) {
  }

  return preg_replace($tag_reg_ex, $start_tag . $script_contents . $end_tag, $buffer);
});

?>
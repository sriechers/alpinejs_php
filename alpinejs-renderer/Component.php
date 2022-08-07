<?php 
  
  /**
   * Component
   *
   * @param  string $template 
   * Pfad zur Template Datei
   * @param  array $state
   * State Objekt das in der HTML Komponente als AlpineJS State Objekt eingebunden wird (x-data)
   * @param  array $props
   * Variablen die zur Komponente weitergeleitet werden
   * @return include AlpineJS Component
   * 
   * HTML Komponente hat Zugriff auf folgende Variablen:
   * $_COMPONENT_ID unique Identifier,
   * $_STATE transformierter State zur Verwendung mit PHP,
   * $_PROPS,
   * $_ALPINE_STATE formatiertes AlpineJS State Objekt zur Verwendung mit x-data
   * get_key() gibt den Schlüssel zu einem Wert im $_STATE zurück
   */
  function Component(string $template, $state = array(), $props = array(), $options = array("allow_duplicate_scripts" => false)){
    include_once("./alpinejs-renderer/utils/format_alpinejs_state_object.php");
    include_once("./alpinejs-renderer/utils/get_key.php");
    
    if(!file_exists($template)){
      throw new ErrorException("Component does not exist: $template");
    }

    $_COMPONENT_GROUP_ID = md5($template);
    $_UNIQUE_ID = $_COMPONENT_GROUP_ID."_".uniqid();
    $_STATE = str_replace(array( "'", '"' ), "", $state);
    $_PROPS = $props;
    $props = null; 
    $_ALPINE_STATE = format_alpinejs_state_object($state);

    $GLOBALS["components"][] = array("id"=>$_UNIQUE_ID, "component_group_id"=>$_COMPONENT_GROUP_ID, "state"=>$_STATE, "props"=>$_PROPS, "alpine_state"=>$_ALPINE_STATE);


    // Template vor der Ausgabe bearbeiten
    ob_start(function ($buffer) use ($options, $_COMPONENT_GROUP_ID){
      $matches = null;
      $script_tag_reg_ex = "/(<script.*?>)([^<]*)(<\/script>)/s";
  
      // Komponente wurde bereits geparsed und doppelte Script Tags in Komponenten sind nicht erlaubt
      if(!$options["allow_duplicate_scripts"] && isset($GLOBALS["parsed_components"]) && in_array($_COMPONENT_GROUP_ID, $GLOBALS["parsed_components"])){
        // Script Tag aus Komponente löschen
        return preg_replace($script_tag_reg_ex, "", $buffer);
      }
  
      // Speichern welche Komponenten geparsed wurden
      $GLOBALS["parsed_components"][] = $_COMPONENT_GROUP_ID;
  
      // Match Script tags
      preg_match($script_tag_reg_ex, $buffer, $matches);
  
      $start_tag = $matches[1];
      $end_tag = $matches[3];
      $script_contents = $matches[2];
  
      return preg_replace($script_tag_reg_ex, $start_tag.$script_contents.$end_tag, $buffer);
    });


    include $template;
    
    // Komponente ausgeben
    ob_end_flush();
  }
?>
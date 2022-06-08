<?php 
  // @include_once("./alpinejs-renderer/utils/Assets.php");
  
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
  function Component(string $template, $state = array(), $props = array()){
    include_once("./alpinejs-renderer/utils/format_alpinejs_state_object.php");
    include_once("./alpinejs-renderer/utils/get_key.php");
    
    if(!file_exists($template)){
      throw new ErrorException("Component does not exist: $template");
    }
    $_COMPONENT_ID = uniqid();
    $_STATE = str_replace(array( "'", '"' ), "", $state);
    $_PROPS = $props;
    $props = null; 
    $_ALPINE_STATE = format_alpinejs_state_object($state);

    include $template;
  }
?>
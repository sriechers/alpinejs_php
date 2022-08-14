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
   * $_COMPONENT_GROUP_ID unique id der Komponentengruppe
   * $_UNIQUE_ID unique Identifier,
   * $_STATE transformierter State zur Verwendung mit PHP,
   * $_PROPS,
   * $_ALPINE_STATE formatiertes AlpineJS State Objekt zur Verwendung mit x-data
   * get_key() gibt den Schlüssel zu einem Wert im $_STATE zurück
  */
  function Component(string $template, $state = array(), $props = array()){
    require_once("./alpinejs-renderer/utils/format_alpinejs_state_object.php");
    require_once("./alpinejs-renderer/ComponentManager.php");
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
    ob_start(function ($buffer) use ($_COMPONENT_GROUP_ID){
      $matches = null;
      $content = $buffer;

      // // Self closing link tags
      // $self_closing_tag_reg_ex = "%(<(link)\s*.*.?/>)%mi"; 
      // preg_match_all($self_closing_tag_reg_ex, $content, $matches, PREG_SET_ORDER);

      // if($matches && count($matches) > 0){
      //   foreach($matches as $match){
          
      //     $tag = $match[1];
      //     // $tag_name = $match[2];
      //     $include_only_once = $tag ? str_contains($tag, "data-include-once") : false;

      //     if($include_only_once && ComponentManager::includes($tag, "script")){
      //       $content = str_replace($tag, "", $content);
      //       continue;
      //     } else {
      //       $content = str_replace($tag, "", $content);
      //       ComponentManager::add_style($tag);
      //     }

      //     // tag löschen
      //     $content = str_replace($tag, "", $content);
      //   }
      // }

      $tag_reg_ex = "%(<(script|style)\s*.*.?>)(.|\n)*?</(script|style)>%mi";
      // Match tags
      preg_match_all($tag_reg_ex, $content, $matches, PREG_SET_ORDER);

      if($matches && count($matches) > 0){
        foreach($matches as $match){
          $tag = $match[0];
          $tag_name = $match[2];
          $include_only_once = $tag ? str_contains($tag, "data-include-once") : false;

          if($tag_name === "script"){
            if($include_only_once && ComponentManager::includes($tag, "script")){
              $content = str_replace($tag, "", $content);
              continue;
            } else {
              $content = str_replace($tag, "", $content);
              ComponentManager::add_script($tag);
            }
          }

          if($tag_name === "style"){
            if($include_only_once && ComponentManager::includes($tag, "style")){
              $content = str_replace($tag, "", $content);
              continue;
            } else {
              $content = str_replace($tag, "", $content);
              ComponentManager::add_style($tag);
            }
          }

          // tag löschen
          $content = str_replace($tag, "", $content);

        }
      }

      $GLOBALS["parsed_components"][] = $_COMPONENT_GROUP_ID;
      return $content;
    });

    
    include $template;
    
    // Komponente ausgeben
    ob_end_flush();
  }
?>
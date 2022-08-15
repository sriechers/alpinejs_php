<?php 
  require_once(__DIR__."/utils/format_alpinejs_state_object.php");
  class ComponentManager {
    private static $style_tags = array();
    private static $script_tags = array();
    private static $components = array();

    static function add_style($tag) {
      self::$style_tags[] = $tag;
    }

    static function add_script($tag) {
      self::$script_tags[] = $tag;
    }

    static function get_components_data() {
      return self::$components;
    }

    static function includes($tag, $type) {
      if($type === "script"){
        return in_array($tag, self::$script_tags);
      }
      if($type === "style"){
        return in_array($tag, self::$style_tags);
      }
    }

    static function get_styles() {
        $output = '';
        foreach(self::$style_tags as $tag) {
            $output .= $tag . "\n";
        }
        return $output;
    }

    static function get_scripts() {
      $output = '';
      foreach(self::$script_tags as $tag) {
          $output .= $tag . "\n";
      }
      return $output;
    }

    private static function handle_tags($matches, $data){
      $content = $data;
      if($matches && count($matches) > 0){
        foreach($matches as $match){
          $tag = $match[0];
          $tag_name = $match[2];
          $include_only_once = str_contains($tag, "data-include-once");

          if($tag_name === "script"){
            if($include_only_once && ComponentManager::includes($tag, "script")){
              $content = str_replace($tag, "", $content);
              continue;
            } else {
              $content = str_replace($tag, "", $content);
              ComponentManager::add_script($tag);
            }
          }

          if($tag_name === "style" || $tag_name === "link"){
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
      return $content;
    }

    /**
     * component
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
    public function component(string $template, $state = array(), $props = array()){
      // require_once("./alpinejs-renderer/ComponentManager.php");
      include_once(__DIR__."/utils/get_key.php");
  
      if(!file_exists($template)){
        throw new ErrorException("Component does not exist: $template");
      }
  
      $_COMPONENT_GROUP_ID = md5($template);
      $_UNIQUE_ID = $_COMPONENT_GROUP_ID."_".uniqid();
      $_STATE = str_replace(array( "'", '"' ), "", $state);
      $_PROPS = $props;
      $props = null; 
      $_ALPINE_STATE = format_alpinejs_state_object($state);
  
      self::$components[] = array("id"=>$_UNIQUE_ID, "component_group_id"=>$_COMPONENT_GROUP_ID, "state"=>$_STATE, "props"=>$_PROPS, "alpine_state"=>$_ALPINE_STATE);
  
      // Template vor der Ausgabe bearbeiten
      ob_start(function ($buffer) use ($_COMPONENT_GROUP_ID){
        $matches = null;
        $content = $buffer;
  
        // Self closing link tags
        $self_closing_tag_reg_ex = "%(<(link)\s*.*.?/>)%mi"; 
        preg_match_all($self_closing_tag_reg_ex, $content, $matches, PREG_SET_ORDER);
        $content = self::handle_tags($matches, $content);
        
        // Normal Tags
        $tag_reg_ex = "%(<(script|style)\s*.*.?>)(.|\n)*?</(script|style)>%mi";
        preg_match_all($tag_reg_ex, $content, $matches, PREG_SET_ORDER);
        $content = self::handle_tags($matches, $content);
  
        $GLOBALS["parsed_components"][] = $_COMPONENT_GROUP_ID;
        return $content;
      });
  
      
      include $template;
      
      // Komponente ausgeben
      ob_end_flush();
    }
  }
?>
<?php 
  class ComponentManager {
    private static $css = array();
    private static $js = array();

    static function add_style($tag) {
      self::$css[] = $tag;
    }

    static function add_script($tag) {
      self::$js[] = $tag;
    }

    static function includes($tag, $type) {
      if($type === "script"){
        return in_array($tag, self::$js);
      }
      if($type === "style"){
        return in_array($tag, self::$css);
      }
    }

    static function get_styles() {
        $output = '';
        foreach(self::$css as $tag) {
            $output .= $tag . "\n";
        }
        return $output;
    }

    static function get_scripts() {
      $output = '';
      foreach(self::$js as $tag) {
          $output .= $tag . "\n";
      }
      return $output;
    }
  }
?>
<?php
// Kann weg (wahrscheinlich)
class Assets {
    private static $css = array();
    private static $js = array();
    
    static function delay_render(){
        ob_start();
    }

    static function add_style($path) {
        self::$css[] = $path;
    }

    static function add_script($path) {
        self::$js[] = $path;
    }

    static function get_styles() {
        $output = "";
        foreach(self::$css as $path) {
            $output .= '<link rel="stylesheet" href="'. $path .'" />' . "\n";
        }
        return $output;
    }

    static function get_scripts() {
        $output = "";
        foreach(self::$js as $path) {
            $output .= '<script type="text/javascript" src="'. $path .'" defer></script>' . "\n";
        }
        // return $output;
        self::create_tag($output);
    }

    // static function get_scripts() {
    //     foreach(self::$js as $path) {
    //         self::create_tag($path, "script");
    //     }
    // }

    static function create_tag($output){
        $current_file_path = basename($_SERVER['REQUEST_URI'].$_SERVER["SCRIPT_NAME"]);
        $contents = file_get_contents($current_file_path);
        echo str_replace("</head>", $output."</head>", $contents);

        // $dom = new DOMDocument;
        // @$dom->loadHTML($url_contents);

        // $tag = null;
        // // if($type === "style"){
        // //     $new_elm = $dom->createElement('link');
        // //     $elm_rel_attr = $dom->createAttribute('rel');
        // //     $elm_rel_attr->value = 'stylesheet';
        // //     $elm_href_attr = $dom->createAttribute('href');
        // //     $elm_href_attr->value = 'stylesheet';
        // // }

        // if($type === "script"){
        //     $tag = $dom->createElement('script',  ' ');
        //     $src = $dom->createAttribute('src');
        //     $src->value = $path;
        // }

        // $head = $dom->getElementsByTagName('head')->item(0);
        // $head->appendChild($tag);
        // return $dom->saveHTML();
    }
}
?>
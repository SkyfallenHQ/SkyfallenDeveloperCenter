<?php
/**
 * Class SDC_Router
 * Handles url routing
 */

class SDC_Router
{
    /**
     * Routes a specific path to a function
     * @param String $path The path to route
     * @param String $func The function to route to
     * @param Boolean $requireLogin Do we need to login to access this page
     * @param String $fallbackfunc The function to route to if we are not logged in
     */
    public static function routePage($path, $func,$requireLogin = false, $fallbackfunc = "null"){
        if($requireLogin) {
            if (REQUEST == $path or REQUEST == $path . "/") {
                if(ISLOGGEDIN) {
                    define("ROUTED",true);
                    $func();
                } else {
                    define("ROUTED",true);
                    $fallbackfunc();
                }
            }
        }
        else {
            if (REQUEST == $path or REQUEST == $path . "/") {
                define("ROUTED",true);
                $func();
            }
        }
    }

    /**
     * Routes urls with a specific beginning to a function
     * @param String $prefix Prefix to look for
     * @param String $func Function to redirect to
     * @param Boolean $noEndTrailingSlash Remove trailing slash from the remaining path
     * @param Boolean $requireLogin Decides whether user should be logged in to view this page
     * @param String $fallbackfunc What to do if user is not logged in, name of a function
     */
    public static function routePrefix($prefix,$func,$noEndTrailingSlash = false,$requireLogin = false, $fallbackfunc = "null"){
        if(substr(REQUEST,0,strlen($prefix)+1) == $prefix."/"){
                $remainingPath = "";
                if($noEndTrailingSlash && substr(REQUEST,strlen(REQUEST)-2,strlen(REQUEST)-1) == "/"){
                    $remainingPath = substr(REQUEST,strlen($prefix),strlen(REQUEST)-2);
                }
                $remainingPath = substr(REQUEST,strlen($prefix)+1,strlen(REQUEST));
                define("ROUTED",true);
                $func($remainingPath);
        }
    }

    /**
     * Renders a static html page
     * @param String $filename Name of the html file without extension
     * @param String $dir The directory that html file exist inside. Defaults to 'static/html'
     */

    public static function render_html($filename,$dir = "static/html"){
        include SDC_ABSPATH."/".$dir."/".$filename.".html";
    }
}
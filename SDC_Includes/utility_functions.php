<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*   This file contains some utility functions that help with the development.     */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Stop it!");

/**
 * Echos the WEB_URL of current application
 */
function the_weburl(){
    echo WEB_URL;
}

/**
 * Echos the url concatenated with an page's url
 * @param String $path Path to the page
 */
function the_pageurl($path){
    echo WEB_URL.$path;
}

/**
 * Echos the url concatenated with an asset's url
 * @param String $path Path to the url inside the app
 */
function the_fileurl($path){
    echo WEB_URL.$path;
}

/**
 * Redirects the user using headers
 * @param String $to The path after the domain to redirect to
 */
function sdc_redirect($to){
    header("location: ".WEB_URL.$to);
}

/**
 * Generates a random MD5 Hash
 * @return String Hash
 */
function rand_md5_hash(){
    return md5(uniqid(rand(), true));
}

/**
 * Validates Post Data
 * @param Array $fields Array of all the fields to validate
 * @return bool
 */
function validatePostData($fields){

    foreach ($fields as $field){

        if(!isset($_POST[$field]) or trim($_POST[$field]) == ""){
            return false;
        }

    }

    return true;

}
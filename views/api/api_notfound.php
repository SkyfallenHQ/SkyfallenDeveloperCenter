<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*       This file contains the function to render an API function                 */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Execute the API 'Not Found' response
 */
function execute_api_notfound($command){

    $r['API']['name'] = "Skyfallen Developer Center API";
    $r['API']['version'] = "Beta 1";
    $r['request']['status'] = "ERROR";
    $r['request']['command'] = $command;
    $r['request']['error']['code'] = 404;
    $r['request']['error']['message'] = 'This endpoint does not exist.';

    die(json_encode($r));
    
}
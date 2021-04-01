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
 * Execute the API 'Index' Query
 */
function execute_api_index(){

    $r['API']['name'] = "Skyfallen Developer Center API";
    $r['API']['version'] = "Beta 1";
    $r['request']['status'] = "OK";
    $r['request']['command'] = 'index';

    echo json_encode($r);
    
}
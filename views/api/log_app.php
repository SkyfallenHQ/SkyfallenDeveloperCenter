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
function execute_api_app_logging(){

    $r['API']['name'] = "Skyfallen Developer Center API";
    $r['API']['version'] = "Beta 1";
    $r['request']['status'] = "OK";
    $r['request']['arguments']['authentication']['service_id'] = safe_return_post_value('service_id');
    $r['request']['arguments']['authentication']['service_secret'] = safe_return_post_value('service_secret');
    $r['request']['arguments']['authentication']['provision_id'] = safe_return_post_value('provision_id');
    $r['request']['arguments']['data']['log_type'] = safe_return_post_value('log_type');
    $r['request']['arguments']['data']['log_data'] = safe_return_post_value('log_data');
    $r['request']['raw_post_data'] = $_POST;
    $r['request']['command'] = 'app-logging/log';

    if(validatePostData(['service_id','service_secret','provision_id','log_type','log_data'])){

        $as = true;

        try {

            $currentProvision = new SDCService($_POST['provision_id']);
    
        } catch (Exception $e){
    
            $as = false;
    
        }

        if($as){
            $as = $currentProvision->validateCredentials($_POST['service_id'],$_POST['service_secret']);
        }

        if($as){

            $ob = json_decode($_POST['log_data']);
            if($ob !== null) {
            
                SDC_LSLog::log($_POST['service_id'],$_POST['log_type'],$_POST['log_data']);

            } else {

                $r['request']['status'] = "ERROR";
                $r['request']['error']['code'] = 500;
                $r['request']['error']['message'] = "The log data passed is not valid JSON. Please check your data."; 

            }

        } else {

            $r['request']['status'] = "ERROR";
            $r['request']['error']['code'] = 403;
            $r['request']['error']['message'] = "The required authentication keys did not pass the validation."; 

        }

    } else {

        $r['request']['status'] = "ERROR";
        $r['request']['error']['code'] = 500;
        $r['request']['error']['message'] = "The required arguments were not passed in the POST request.";

    }

    echo json_encode($r);
    
}


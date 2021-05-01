<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*     This file contains the function to render the App Logging API page          */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'App Logging' page
 */
function render_logging_app_page($app,$urlm){

    $urlm[0] = $app;

    if(!isset($urlm[2])){
        $urlm[2] = false;
    }

    $app = new SDCApp($app);

    if($urlm[2] != "view"){

        $csrf = new SDC_CSRF();

        $currentProvision = null;
        $pID = "";
        $pSID = "";
        $pSS = "";

        $ts = "";

        $toggleMsg = "Logging Service is currently disabled for this app. Click on the toggle to enable it for this app.";

        $df = true;

        try {

            $currentProvision = new SDCService($app->obj->identifier.".app-logging-service");

        } catch (Exception $e){

            $df = false;

        }

        if($df){

            $pID = $currentProvision->safeProvisionMeta('provisionid');
            $pSID = $currentProvision->safeProvisionMeta('serviceid');
            $pSS = $currentProvision->safeProvisionMeta('servicesecret');
            $ts = "checked";
            $toggleMsg = "Logging Service is currently enabled for this app. Click on the toggle to disable this service for this app and revoke the provision tokens visible.";

        }

        if(!empty($_POST) && SDC_CSRF::verifyCSRF()){

            SDC_CSRF::invalidateCurrentCSRF();
            if(isset($_POST['api-status'])){

                if($currentProvision == null){

                    SDCService::provisionService($app,"app-logging-service");
                    $currentProvision = null;
                    $pID = "";
                    $pSID = "";
                    $pSS = "";

                    $ts = "";

                    $toggleMsg = "Logging Service is currently disabled for this app. Click on the toggle to enable it for this app.";

                    $df = true;

                    try {

                        $currentProvision = new SDCService($app->obj->identifier.".app-logging-service");

                    } catch (Exception $e){

                        $df = false;

                    }

                    if($df){

                        $pID = $currentProvision->safeProvisionMeta('provisionid');
                        $pSID = $currentProvision->safeProvisionMeta('serviceid');
                        $pSS = $currentProvision->safeProvisionMeta('servicesecret');
                        $ts = "checked";
                        $toggleMsg = "Logging Service is currently enabled for this app. Click on the toggle to disable this service for this app and revoke the provision tokens visible.";

                    }

                }

            } else {

                if($currentProvision != null && !isset($_POST['clearlogs'])){

                    SDC_LSLog::clearLogs($currentProvision->safeProvisionMeta('serviceid'));
                    $currentProvision->delete();
                    $currentProvision = null;
                    $pID = "";
                    $pSID = "";
                    $pSS = "";

                    $ts = "";

                    $toggleMsg = "Logging Service is currently disabled for this app. Click on the toggle to enable it for this app.";

                    $df = true;

                    try {

                        $currentProvision = new SDCService($app->obj->identifier.".app-logging-service");

                    } catch (Exception $e){

                        $df = false;

                    }

                    if($df){

                        $pID = $currentProvision->safeProvisionMeta('provisionid');
                        $pSID = $currentProvision->safeProvisionMeta('serviceid');
                        $pSS = $currentProvision->safeProvisionMeta('servicesecret');
                        $ts = "checked";
                        $toggleMsg = "Logging Service is currently enabled for this app. Click on the toggle to disable this service for this app and revoke the provision tokens visible.";

                    }

                } else {
                    if(isset($_POST['clearlogs'])){
                        SDC_LSLog::clearLogs($currentProvision->safeProvisionMeta('serviceid'));
                    }
                }

            }

        }
    } else {

        try{

            $currentProvision = new SDCService($app->obj->identifier.".app-logging-service");
            $log = new SDC_LSLog($urlm[3],$currentProvision->safeProvisionMeta('serviceid'));

        } catch (Exception $e){

            include_once SDC_ABSPATH."/SDC_Includes/404.php";
            die();

        }

    }

    ?>
    <html>
    <head>
        <title>Skyfallen Developer Center</title>
        <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.min.js"); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/app-logging-service-page.css?revision=3"); ?>">
        <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
        <script type="text/javascript" src="<?php the_fileurl("static/js/greeting.js"); ?>"></script>
        <script type="text/javascript" src="<?php the_fileurl("static/js/app_logging_service_page.js?revision=2"); ?>"></script>
        <?php 
            if($urlm[2] != "view"){
        ?>
        <script>
            $(document).ready(function () {
                addPagerToTable(document.getElementById('log-table'), 10);
            })
        </script>
        <?php } ?>
    </head>
    <body>
    <?php
    include SDC_ABSPATH."/partials/app-side-menu.php";
    ?>

    <div class="content" id="content" style="margin-left: 300px;">
        <?php
        include SDC_ABSPATH."/partials/app-top-menu.php";
        ?>


        <div class="welcome-msg">
            <p class="welcome-msg-left" id="greeting">Hi <?php
                if($_SESSION['user']->safeParseProfile('name') != ""){
                    echo $_SESSION['user']->safeParseProfile('name');
                } else {
                    echo $_SESSION['user']->obj->username;
                }
                ?>,</p><p class="welcome-msg-desc">Welcome to all-new Skyfallen Developer Center. Here you can manage Skyfallen Hosted error logging service for you any type of app to monitor and centrally log their errors, data and exceptions!</p>
            <svg viewBox='0 0 512 512' id="welcome-hand-wave"><path d='M80 320V144a32 32 0 0132-32h0a32 32 0 0132 32v112M144 256V80a32 32 0 0132-32h0a32 32 0 0132 32v160M272 241V96a32 32 0 0132-32h0a32 32 0 0132 32v224M208 240V48a32 32 0 0132-32h0a32 32 0 0132 32v192' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/><path d='M80 320c0 117.4 64 176 152 176s123.71-39.6 144-88l52.71-144c6.66-18.05 3.64-34.79-11.87-43.6h0c-15.52-8.82-35.91-4.28-44.31 11.68L336 320' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/></svg>
        </div>

        <?php 
            if($urlm[2] != "view"){
        ?>
        <div class="col2">
            <div class="status-box">
                <div class="status-headline">
                    <p>App Logging API Status</p>
                </div>
                <form method="post" id="status-form">
                    <p><?php echo $toggleMsg; ?></p>
                    <?php
                       $csrf->put();
                    ?>
                    <label class="switch">
                        <input type="checkbox" name="api-status" id="api-status" <?php echo $ts; ?>>
                        <span class="slider round"></span>
                    </label>
                </form>
            </div>
            <div class="token-box">
                <div class="token-headline">
                    <p>Service Provisions</p>
                </div>
                <div class="token-box-iw">
                    <label for="prov-id" class="lbl">Provision ID</label> <input value="<?php echo $pID; ?>" class="token-field" id="prov-id" disabled>

                    <label for="prov-id" class="lbl">Service ID</label> <input value="<?php echo $pSID; ?>" class="token-field" id="svc-id" disabled>

                    <label for="prov-id" class="lbl">Service Secret</label> <input value="<?php echo $pSS; ?>" class="token-field" id="svc-secret" disabled>
                </div>
            </div>
            <div class="log-box">
                <div class="lb-headline">
                    <p style="display: inline-block;">Logs for this app</p>
                    <input type="text" class="token-field" placeholder="Search with ID..." id="logsearch" style="width: 200px;" onkeyup="searchLogs()">
                    <form method="post">
                        <?php $csrf->put(); ?>
                        <input name="clearlogs" hidden>
                        <button type="submit" class="clear-logs-btn"><svg style="height: 25px; width: 25px;"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                    </form>
                </div>
                <div class="lb-box-iw">
                    <table id="log-table">
                        <thead>
                        <tr>
                            <th>Time</th>
                            <th>Type</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                    
                        $logs = SDC_LSLog::listLogs($pSID);

                        foreach($logs as $log){

                            echo "<tr>";
                            echo "<td style='display: none;'>".$log->obj->logid."</td>";
                            echo "<td>".date('l jS F Y h:i:s A',$log->obj->time)."</td>";
                            echo "<td>".$log->obj->logtype."</td>";
                            echo "<td><a href=\"".WEB_URL."apps/manage/".$app->obj->appid."/app-logging/view/".$log->obj->logid."\">View</a></td>";
                            echo "</tr>";

                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } else { ?>
            <div class="welcome-msg" style="padding-top: 35px; height: fit-content;">
                <div class="lb-headline">
                    <p>Log Viewer</p>
                </div>
                <div class="lb-box-iw" style="text-align: left; padding-left: 20px;">
                    <h3><?php echo $log->obj->logtype; ?></h4>
                    <h4><?php echo date('l jS F Y h:i:s A',$log->obj->time); ?></h3>
                    <pre style="width: fit-content; height: fit-content; min-width: 60%;"><?php
                            echo json_encode(json_decode($log->obj->logdata), JSON_PRETTY_PRINT);
                        ?></pre>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
    </body>
    </html>
<?php }

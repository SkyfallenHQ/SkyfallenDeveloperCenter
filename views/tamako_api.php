<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*        This file contains the function to render the Tamako API page             */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'Tamako' page
 */
function render_tamako_app_page($app){

    $urlm[0] = $app;
    $csrf = new SDC_CSRF();

    $app = new SDCApp($app);

    $currentProvision = null;
    $pID = "";
    $pSID = "";
    $pSS = "";

    $ts = "";

    $toggleMsg = "Tamako API is currently disabled for this app. Click on the toggle to enable this app.";

    $df = true;

    try {

        $currentProvision = new SDCService($app->obj->identifier.".tamako-api");

    } catch (Exception $e){

        $df = false;

    }

    if($df){

        $pID = $currentProvision->safeProvisionMeta('provisionid');
        $pSID = $currentProvision->safeProvisionMeta('serviceid');
        $pSS = $currentProvision->safeProvisionMeta('servicesecret');
        $ts = "checked";
        $toggleMsg = "Tamako API is currently enabled for this app. Click on the toggle to this this service for this app and revoke the provision tokens visible.";

    }

    if(!empty($_POST) && SDC_CSRF::verifyCSRF()){

        SDC_CSRF::invalidateCurrentCSRF();
        if(isset($_POST['api-status'])){

            if($currentProvision == null){

                SDCService::provisionService($app,"tamako-api");
                $currentProvision = null;
                $pID = "";
                $pSID = "";
                $pSS = "";

                $ts = "";

                $toggleMsg = "Tamako API is currently disabled for this app. Click on the toggle to enable this app.";

                $df = true;

                try {

                    $currentProvision = new SDCService($app->obj->identifier.".tamako-api");

                } catch (Exception $e){

                    $df = false;

                }

                if($df){

                    $pID = $currentProvision->safeProvisionMeta('provisionid');
                    $pSID = $currentProvision->safeProvisionMeta('serviceid');
                    $pSS = $currentProvision->safeProvisionMeta('servicesecret');
                    $ts = "checked";
                    $toggleMsg = "Tamako API is currently enabled for this app. Click on the toggle to this this service for this app and revoke the provision tokens visible.";

                }

            }

        } else {

            if($currentProvision != null){

                $currentProvision->delete();
                $currentProvision = null;
                $pID = "";
                $pSID = "";
                $pSS = "";

                $ts = "";

                $toggleMsg = "Tamako API is currently disabled for this app. Click on the toggle to enable this app.";

                $df = true;

                try {

                    $currentProvision = new SDCService($app->obj->identifier.".tamako-api");

                } catch (Exception $e){

                    $df = false;

                }

                if($df){

                    $pID = $currentProvision->safeProvisionMeta('provisionid');
                    $pSID = $currentProvision->safeProvisionMeta('serviceid');
                    $pSS = $currentProvision->safeProvisionMeta('servicesecret');
                    $ts = "checked";
                    $toggleMsg = "Tamako API is currently enabled for this app. Click on the toggle to this this service for this app and revoke the provision tokens visible.";

                }

            }

        }

    }

    ?>
    <html>
    <head>
        <title>Skyfallen Developer Center</title>
        <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.min.js"); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/tamako-api-page.css"); ?>">
        <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
        <script type="text/javascript" src="<?php the_fileurl("static/js/greeting.js"); ?>"></script>
        <script type="text/javascript" src="<?php the_fileurl("static/js/tamako_api_page.js"); ?>"></script>
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
                ?>,</p><p class="welcome-msg-desc">Welcome to all-new Skyfallen Developer Center. Here you can manage natural chat via an api as seen on Tamako for your app.</p>
            <svg viewBox='0 0 512 512' id="welcome-hand-wave"><path d='M80 320V144a32 32 0 0132-32h0a32 32 0 0132 32v112M144 256V80a32 32 0 0132-32h0a32 32 0 0132 32v160M272 241V96a32 32 0 0132-32h0a32 32 0 0132 32v224M208 240V48a32 32 0 0132-32h0a32 32 0 0132 32v192' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/><path d='M80 320c0 117.4 64 176 152 176s123.71-39.6 144-88l52.71-144c6.66-18.05 3.64-34.79-11.87-43.6h0c-15.52-8.82-35.91-4.28-44.31 11.68L336 320' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/></svg>
        </div>

        <div class="col2">
            <div class="status-box">
                <div class="status-headline">
                    <p>Tamako API Status</p>
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
        </div>
    </div>
    </body>
    </html>
<?php }
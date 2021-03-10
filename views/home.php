<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*          This file contains the function to render the home page                */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'Home' page
 */
function render_dev_home(){
?>
<html>
<head>
    <title>Skyfallen Developer Center</title>
    <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.min.js"); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/home.css"); ?>">
    <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
    <script type="text/javascript" src="<?php the_fileurl("static/js/greeting.js"); ?>"></script>
</head>
<body>
<?php

if($_SESSION['user']->obj->accountstatus == "PENDING_VALIDATION"){
    ?>
    <div class="validate-notice">Your account is pending validation. <br> Please complete your profile and submit for validation.</div>
    <?php
}

if($_SESSION['user']->obj->accountstatus == "IN_REVIEW"){
    ?>
    <div class="validate-notice">Your account is being validated. <br> Skyfallen will contact you via email when it is complete. </div>
    <?php
}

include SDC_ABSPATH."/partials/side-menu.php";
?>

<div class="content" id="content" style="margin-left: 300px;">
    <?php
    include SDC_ABSPATH."/partials/top-menu.php";
    ?>


    <div class="welcome-msg">
        <p class="welcome-msg-left" id="greeting">Hi <?php
            if($_SESSION['user']->safeParseProfile('name') != ""){
                echo $_SESSION['user']->safeParseProfile('name');
            } else {
                echo $_SESSION['user']->obj->username;
            }
            ?>,</p><p class="welcome-msg-desc">Welcome to all-new Skyfallen Developer Center. Here you can find your apps
            API Tokens, Developer Docs and your Developer Profile.</p>
            <svg viewBox='0 0 512 512' id="welcome-hand-wave"><path d='M80 320V144a32 32 0 0132-32h0a32 32 0 0132 32v112M144 256V80a32 32 0 0132-32h0a32 32 0 0132 32v160M272 241V96a32 32 0 0132-32h0a32 32 0 0132 32v224M208 240V48a32 32 0 0132-32h0a32 32 0 0132 32v192' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/><path d='M80 320c0 117.4 64 176 152 176s123.71-39.6 144-88l52.71-144c6.66-18.05 3.64-34.79-11.87-43.6h0c-15.52-8.82-35.91-4.28-44.31 11.68L336 320' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/></svg>
    </div>

    <div class="col2">
        <div class="announcements-box">
            <div class="announcements-headline">
                <p>Latest Announcements</p>
            </div>
            <div class="announcement-wrap" style="margin-top: 70px;">
                <p class="announcement-title">All new SDC is now in beta</p>
                <p class="announcement-info">By Skyfallen Worldwide Developer Relations - Today on 12.11PM</p>
            </div>
            <div class="announcement-wrap">
                <p class="announcement-title">All new SDC is now in beta</p>
                <p class="announcement-info">By Skyfallen Worldwide Developer Relations - Today on 12.11PM</p>
            </div>
            <div class="announcement-wrap">
                <p class="announcement-title">All new SDC is now in beta</p>
                <p class="announcement-info">By Skyfallen Worldwide Developer Relations - Today on 12.11PM</p>
            </div>
            <div class="announcement-wrap">
                <p class="announcement-title">All new SDC is now in beta</p>
                <p class="announcement-info">By Skyfallen Worldwide Developer Relations - Today on 12.11PM</p>
            </div>
        </div>
        <div class="getstarted-box">
            <div class="getstarted-headline">
                <p>Getting Started</p>
            </div>

            <div class="gs-step" style="margin-top: 70px; cursor: pointer;" onclick="openPage('<?php the_weburl(); ?>apps')">
                <p class="gs-step-text">Create your first app</p>
                <svg style="height: 25px; width: 25px; position: absolute; top: 22px; right:30px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>

            <div class="gs-step" style="cursor: pointer;" onclick="openPage('<?php the_weburl(); ?>profile')">
                <p class="gs-step-text">Setup your profile</p>
                <svg style="height: 25px; width: 25px; position: absolute; top: 22px; right:30px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>

            <div class="gs-step" style="cursor: pointer;" onclick="openPage('<?php the_weburl(); ?>docs')">
                <p class="gs-step-text">Read the docs</p>
                <svg style="height: 25px; width: 25px; position: absolute; top: 22px; right:30px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>

        </div>
    </div>
</div>
</body>
</html>
<?php }
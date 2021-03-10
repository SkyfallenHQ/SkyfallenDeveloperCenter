<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*           This file contains the function to render docs page                   */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'Docs' page
 */
function render_dev_docs(){
?>
<html>
<head>
    <title>Skyfallen Developer Center</title>
    <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.min.js"); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/docs.css"); ?>">
    <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
</head>
<body>
<?php
include SDC_ABSPATH."/partials/side-menu.php";
?>

<div class="content" id="content" style="margin-left: 300px;">
    <?php
    include SDC_ABSPATH."/partials/top-menu.php";
    ?>
<div class="docs-container">
    <div class="docs" onclick="openPage('https://docs.theskyfallen.com')">

        <svg style="height: 175px; width: 175px; margin: auto; display: block; padding-top: 60px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        <p class="docs-text">End User<br>Documentation</p>
    </div>
    <div class="docs" onclick="openPage('https://docs.developers.theskyfallen.com/')">
        <svg style="height: 175px; width: 175px; margin: auto; display: block; padding-top: 60px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-code"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
        <p class="docs-test">Developer<br>Documentation</p>
    </div>
</div>

</div>
</body>
</html>
<?php }
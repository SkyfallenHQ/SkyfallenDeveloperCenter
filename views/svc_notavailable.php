<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*   This file contains the function to render an app's unavailable services page   */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'Service Not Available' page
 */
function render_svc_not_available($svc){
?>

    <html>
    <head>
        <title>This service is not available</title>
        <link href="<?php the_fileurl("static/css/four-o-four.css"); ?>" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@200&display=swap" rel="stylesheet">
    </head>

    <body>
    <div class="basic-wrapper-01">
        <h1 id="404">Unavailable</h1>
        <h6 id="404-explanation"><?php echo $svc; ?> is not available at this beta of Skyfallen Developer Center. <br>More services are made available on every new version of Skyfallen Developer Center.</h6>
    </div>
    </body>
    </html>


<?php }
<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                  Skyfallen Developer Center Developed by                        */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*         This file contains the function to render the profile page              */
/***********************************************************************************/

// Check if called from the main file
defined("SDC_ABSPATH") or die("Direct access is not allowed.");
/**
 * Renders the 'Profile' page
 */
function render_dev_profile(){


    $countries = array("","Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
    $jobs = array("","Marketer","Developer","Founder/CEO","Lead Developer","API Manager","Freelancer");


    $csrf = new SDC_CSRF();

    $message = "Edit your profile here.";

    $irs = "";

    if($_SESSION['user']->obj->accountstatus == "IN_REVIEW"){
        $irs = "disabled";
    }

    if(!empty($_POST) && SDC_CSRF::verifyCSRF() && $_SESSION['user']->obj->accountstatus != "IN_REVIEW"){

        SDC_CSRF::invalidateCurrentCSRF();
        $_SESSION['user']->saveNewProfile($_POST['user-name'],$_POST['user-surname'],$_POST['user-bdate'],$_POST['user-phone'],$_POST['user-nationality'],$_POST['user-job']);
        $message = "Your profile was updated successfully";
        if(isset($_POST['sfv'])){
            if(isset($_POST['user-name']) && isset($_POST['user-surname']) && isset($_POST['user-bdate']) && isset($_POST['user-phone']) && isset($_POST['user-nationality']) && isset($_POST['user-job']) && trim($_POST['user-job']) != "" && trim($_POST['user-nationality']) != "" && trim($_POST['user-bdate']) != "" && trim($_POST['user-name']) != "" && trim($_POST['user-surname']) != "" && trim($_POST['user-phone']) != ""){
                $_SESSION['user']->sendForValidation();
                $message = "Your account was successfully sent for validation. You may not edit it before validation is complete.";
            } else {
                $message = "Your profile must be completed before sending for validation.";
            }

        }


    }

    ?>
    <html>
    <head>
        <title>Skyfallen Developer Center</title>
        <script type="text/javascript" src="<?php the_fileurl("static/js/jquery.min.js"); ?>"></script>
        <script>
            const WEB_URL = "<?php echo WEB_URL; ?>";
        </script>
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/side-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/top-menu.css"); ?>">
        <link rel="stylesheet" type="text/css" href="<?php the_fileurl("static/css/profile.css"); ?>">
        <script type="text/javascript" src="<?php the_fileurl("static/js/sidebar.js"); ?>"></script>
    </head>
<body>
    <?php
    include SDC_ABSPATH."/partials/side-menu.php";
    ?>

<div class="content" id="content" style="margin-left: 300px;">
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

    include SDC_ABSPATH."/partials/top-menu.php";
    ?>
<div class="welcome-msg">
    <p class="welcome-msg-left">Skyfallen Developer Profile</p>
    <p class="welcome-msg-left" style="font-size: 13px;"><?php echo $message; ?></p>
    <svg viewBox='0 0 512 512' id="welcome-hand-wave"><path d='M80 320V144a32 32 0 0132-32h0a32 32 0 0132 32v112M144 256V80a32 32 0 0132-32h0a32 32 0 0132 32v160M272 241V96a32 32 0 0132-32h0a32 32 0 0132 32v224M208 240V48a32 32 0 0132-32h0a32 32 0 0132 32v192' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/><path d='M80 320c0 117.4 64 176 152 176s123.71-39.6 144-88l52.71-144c6.66-18.05 3.64-34.79-11.87-43.6h0c-15.52-8.82-35.91-4.28-44.31 11.68L336 320' fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'/></svg>
    <form method="post">
        <?php
            $csrf->put();
        ?>
    <div class="profile-wrap">
        <div class="profile-col">
            <label for="user-name">Your Name:</label>
            <input class="profile-input" id="user-name" name="user-name" value="<?php echo $_SESSION['user']->safeParseProfile('name'); ?>" <?php echo $irs ?>>
            <label for="user-surname">Your Last Name:</label>
            <input class="profile-input" id="user-surname" name="user-surname" value="<?php echo $_SESSION['user']->safeParseProfile('surname'); ?>" <?php echo $irs ?>>
            <label for="user-email">Your Email:</label>
            <input class="profile-input" id="user-email" name="user-email" disabled value="<?php echo $_SESSION['user']->obj->email; ?>" <?php echo $irs ?>>
            <label for="user-phone">Your Phone Number:</label>
            <input class="profile-input" id="user-phone" name="user-phone" value="<?php echo $_SESSION['user']->safeParseProfile('phone'); ?>" <?php echo $irs ?>>
        </div>
        <div class="profile-col" id="profile-rcol">
            <label for="user-nationality">Your Country:</label>
            <select class="profile-input" id="user-nationality" name="user-nationality" <?php echo $irs ?>>
                <?php

                $userCountry = $_SESSION['user']->safeParseProfile('country');

                foreach ($countries as $country){

                    $selected = "";

                    if($userCountry == $country){

                        $selected = "selected";

                    }

                    echo "<option value='".$country."' ".$selected.">".$country."</option>";

                }

                ?>
            </select>
            <label for="user-job">Your Job:</label>
            <select class="profile-input" id="user-job" name="user-job" <?php echo $irs ?>>
                <?php

                $userJob = $_SESSION['user']->safeParseProfile('job');

                foreach ($jobs as $uj){

                    $selected = "";

                    if($userJob == $uj){

                        $selected = "selected";

                    }

                    echo "<option value='".$uj."' ".$selected.">".$uj."</option>";

                }

                ?>
            </select>
            <label for="user-bdate">Your Birth Date:</label>
            <input class="profile-input" id="user-bdate" name="user-bdate" value="<?php echo $_SESSION['user']->safeParseProfile('bdate'); ?>" type="date" <?php echo $irs ?>>
            <label id="account-status">Account Status: <?php echo $_SESSION['user']->getNiceAccountState(); ?></label>
            <?php

                if($_SESSION['user']->obj->accountstatus == "PENDING_VALIDATION"){
                    ?>
                    <button type="submit" class="profile-input" style="width: 250px; display: block; margin-bottom: 10px;" name="sfv">Submit for Validation</button>
                    <?php
                }

                if($_SESSION['user']->obj->accountstatus != "IN_REVIEW"){
                    ?>
                    <button type="submit" class="profile-input" style="width: 250px;">Save Profile</button>
                    <?php
                }

            ?>
        </div>
    </div>
    </form>
</div>
</div>
</body>
</html>
<?php }

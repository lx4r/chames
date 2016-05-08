<?php
$loggedIn = false;
/* Verify that the right secret is saved in the session */
if (isset($_SESSION['secret']) && $_SESSION['secret'] = $config['sessionSecret']){
    /* Check whether the session is older than 30 minutes and log the user out if that's the case */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        session_unset();     // Unset the session variable
        session_destroy();   // Destroy the session data in memory
        
        /* Session is new enough -> user authorised */
    } else {
        $loggedIn = true;
        $_SESSION['LAST_ACTIVITY'] = time(); // Update the session's timestamp
    }
    /* If the right secret can't be found in the session the user stays logged out */
}

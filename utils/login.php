<?php
/* Logic for the login form */
if (isset($_POST['submitPassword'])){
    /* .. verify that the hash of the password matches the hash of the right password (algorithm: Bcrypt) ... */
    if (password_verify($_POST['password'], $config['rightPasswordHash'])){
        /* ... if the hash matches the user is authorised */
        $loggedIn = true;
        $_SESSION['secret'] = $config['sessionSecret']; // Write the secret to the session
        $_SESSION['LAST_ACTIVITY'] = time(); // Set the session's timestamp
    } else {
        /* ... if not he stays logged out and an error message is shown */
        $errorWrongPassword = true;
    }
}
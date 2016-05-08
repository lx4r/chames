<?php
if (isset($_POST['logout'])){
    session_unset();     // Unset the session variable
    session_destroy();   // Destroy the session data in memory
}
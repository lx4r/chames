<?php
$config= [
    /* The email adress the notification emails will be sent to */
    'userEmail' => 'noreply@example.com',

    /* The email adress the notification emails will come from */
    'senderEmail' => 'noreply@example.com',

    /* The HTML body of the notification email */
    /* Available placeholders that will be replaced by the game's information: {gameName}, {gamePrice}, {gameURL}, {sellerCountry}, {sellerRating}, {sellerSells} */
    'emailText' =>
        'Hey,<br>the game {gameName} is now <a href="{gameURL}">available on g2a.com</a> for {gamePrice} ({lowestPrice}).<br>
The seller is from {sellerCountry} and has a rating of {sellerRating}% (based on {sellerSells} sells).<br>
    <br>
    The alert for this game is now disabled. Please go to the web interface of this tool to reactivate it.<br>
    <br>
    Your price watchdog',

    /* The subject of the notification emails */
    /* Available placeholder that will be replaced by the game's name: {gameName} */
    'emailSubject' => '{gameName} is now available for your desired price',

    /* Location of the data file */
    'dataFile' => __DIR__ . '/data.php',
    
    /* -------------
    Replace this section with the values from setup.php */
    
    /* Secret saved in the session to make it unique */
    'sessionSecret' => 'hlrMkPR8wH',

    /* API secret used for authenticating the mobile app */
    'apiSecret' => 'hlrMkPR8wH',
    
    /* Default password: "password" */
    'rightPasswordHash' => '$2y$10$ueBR3zRV3W/H.z2hBDxwh..16NeIwTVVQOCdBHTUVnj9ahVanXCcu',
    
    // -------------
];

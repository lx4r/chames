<?php
$config= [
    'userEmail' => 'noreply@example.com',
    'senderEmail' => 'noreply@example.com',
    'emailText' =>
        'Hey,<br>the game {gameName} is now available for {gamePrice} on g2a.com.<br>
The seller is from {sellerCountry} and has a rating of {sellerRating}% (based on {sellerSells} sells).<br>
    <br>
    The alert for this game is now disabled. Please go to the web interface of this tool to reactivate it.<br>
    <br>
    Your price watchdog',
    'emailSubject' => '{gameName} is now available for your desired price',
    'dataFile' => __DIR__ . '/data.json',
    'sessionSecret' => 'hlrMkPR8wH',
    /* Default password: "password" */
    'rightPasswordHash' => '$2y$10$ueBR3zRV3W/H.z2hBDxwh..16NeIwTVVQOCdBHTUVnj9ahVanXCcu',
];
<?php
$configUserEmail = '';
$configSenderEmail = 'noreply@example.com';
$configEmailText = 
    "Hey,<br>
    the game {gameName} is now available for {gamePrice} on g2a.com.<br>
    The seller is from {sellerCountry} and has a rating of {sellerRating}% (based on {sellerSells} sells).<br>
    <br>
    The alert for this game is now disabled. Please go to the web interface of this tool to reactivate it.<br>
    <br>
    Your price watchdog";
$configEmailSubject = "{gameName} is now available for your desired price";
$configDataFile = __DIR__ . '/data.json';
<?php
$configUserEmail = '';
$configSenderEmail = 'noreply@example.com';
$configEmailText = 
    "Hey,\r\n
    the game {gameName} is now available for {gamePrice} on g2a.com.\r\n
    The seller is from {sellerCountry} and has a rating of {sellerRating}% (based on {sellerSells} sells).\r\n
    \r\n
    Your price watchdog";
$configEmailSubject = "{gameName} is now available for your desired price";

/*
 * Example config:
 * ----
 * $configGames = array(
 *   array(
 *     'name' => 'Kerbal Space Programme',
 *     'id' => 4422,
 *     'notificationLimit' => 13,
 *   ),
 * );
 * ----
 * name: name of the game
 * id: can be obtained by opening the game's site on g2a.com and searching for "entity_id" in the source code (should be in a Java Script block)
 * notificationLimit: when the game is available for this price or less an email will be sent to you
 */
$configGames = array();
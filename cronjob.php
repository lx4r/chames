<?php
require_once('config.php');
require_once('get_game_data.php');

foreach ($configGames as $game){
    $data = GetAuctionData($game['id']);
    if ($data['price'] <= $game['notificationLimit']){
        $emailText = $configEmailText;
        $emailText = str_replace('{gameName}', $game['name'], $emailText);
        $emailText = str_replace('{gamePrice}', $data['price'], $emailText);
        $emailText = str_replace('{sellerCountry}', $data['country'], $emailText);
        $emailText = str_replace('{sellerRating}', $data['rating'], $emailText);
        $emailText = str_replace('{sellerSells}', $data['sells'], $emailText);
        $emailSubject = str_replace('{gameName}', $game['name'], $configEmailSubject);
        $emailHeader = 'From: ' . $configSenderEmail . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($configUserEmail, $emailSubject, $emailText, $emailHeader);
    }
}
?>
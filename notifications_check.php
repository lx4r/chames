<?php
require_once('config.php');
require_once('get_game_data.php');
require_once('data_management.php');

$data = LoadData($configDataFile);
$changed = false;

foreach ($data as $key => $game){
    if ($game['active']){
        $auctionData = GetAuctionData($game['gameID']);
        if ($auctionData['price'] <= $game['notificationLimit']){
            $emailText = $configEmailText;
            $emailText = str_replace('{gameName}', $game['gameName'], $emailText);
            $emailText = str_replace('{gamePrice}', $auctionData['price'], $emailText);
            $emailText = str_replace('{sellerCountry}', $auctionData['country'], $emailText);
            $emailText = str_replace('{sellerRating}', $auctionData['rating'], $emailText);
            $emailText = str_replace('{sellerSells}', $auctionData['sells'], $emailText);
            $emailSubject = str_replace('{gameName}', $game['gameName'], $configEmailSubject);
            $emailHeader =
                'From: ' . $configSenderEmail . "\r\n" .
                'X-Mailer: PHP/' . phpversion() . "\r\n" .
                "Content-type: text/html; charset=UTF-8";

            mail($configUserEmail, $emailSubject, $emailText, $emailHeader);
            $data[$key]['active'] = false;
            if(!$changed){
                $changed = true;
            }
        }
    }
}
if ($changed){
    SaveData($configDataFile, $data);
}
?>
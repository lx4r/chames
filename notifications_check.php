<?php
require_once('config.php');
require_once('get_game_data.php');
require_once('data_management.php');

$data = LoadData($configDataFile);

if ($data == null){
    $changed = false;

    foreach ($data as $key => $game){
        if ($game['active']){
            $auctionData = GetAuctionData($game['gameID']);
            if ($auctionData['price'] <= $game['notificationLimit']){

                $placeholders = ['{gameName}', '{gamePrice}', '{gameURL}', '{sellerCountry}', '{sellerRating}', '{sellerSells}'];
                $values = [$game['gameName'], $auctionData['price'], $game['gameURL'], $auctionData['country'], $auctionData['rating'], $auctionData['sells']];
                $emailText = str_replace($placeholders, $values, $config['emailText']);

                $emailSubject = str_replace('{gameName}', $game['gameName'], $config['emailSubject']);

                $emailHeader =
                    'From: ' . $configSenderEmail . "\r\n" .
                    'X-Mailer: PHP/' . phpversion() . "\r\n" .
                    "Content-type: text/html; charset=UTF-8";

                mail($config['userEmail'], $emailSubject, $emailText, $emailHeader);

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
}
?>
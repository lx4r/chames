<?php
require_once('config.php');
require_once('utils/get_game_data.php');
require_once('utils/data_management.php');

$data = LoadData($config['dataFile']);

if ($data != false){
    $changed = false;

    foreach ($data as $key => $game){
        if ($game['active']){
            $auctionData = GetAuctionData($game['gameID']);

            if ($auctionData === false) {
                continue;
            }

            /* If the saved lowest price is higher than the current price replace it with the current price and then save the changes to the JSON file */
            if ($game['lowestPrice'] > $auctionData['price']){
                $data[$key]['lowestPrice'] = $auctionData['price'];
                $changed = true;
            }

            if ($auctionData['price'] <= $game['notificationLimit']){
                if ($game['lowestPrice'] == $auctionData['price']){
                    $lowestPrice = "lowest yet";
                } else {
                    $lowest = "lowest: " . $game['lowestPrice'];
                }

                /* Replace the placeholders in the email strings with the actual values */
                $placeholders = ['{gameName}', '{gamePrice}', '{gameURL}', '{sellerCountry}', '{sellerRating}', '{sellerSells}', '{lowestPrice}'];
                $values = [$game['gameName'], $auctionData['price'], $game['gameURL'], $auctionData['country'], $auctionData['rating'], $auctionData['sells'], $lowestPrice];
                $emailText = str_replace($placeholders, $values, $config['emailText']);
                $emailSubject = str_replace('{gameName}', $game['gameName'], $config['emailSubject']);

                $emailHeader =
                    'From: ' . $config['senderEmail'] . "\r\n" .
                    'X-Mailer: PHP/' . phpversion() . "\r\n" .
                    "Content-type: text/html; charset=UTF-8";

                /* Send the email and disable the alert for this game*/
                mail($config['userEmail'], $emailSubject, $emailText, $emailHeader);
                $data[$key]['active'] = false;

                $changed = true;
            }
        }
    }
    /* If an email was sent save the new status of the game's alert (now disbaled) to the data file */
    if ($changed){
        SaveData($config['dataFile'], $data);
    }
}
?>

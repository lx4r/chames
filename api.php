<?php
require_once('config.php');
require_once('utils/get_game_data.php');
require_once('utils/data_management.php');

/* Prepare the data for the API call result */
$data = LoadData($config['dataFile']);
$result = array();

$comments = file_get_contents($configDataFile);
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $request = json_decode(file_get_contents('php://input'), true);

    /* Check whether the API secret is valid */
    if ($config['apiSecret'] == $request['apiSecret']){

        /* Request type given? If yes: Differ between request types */
        if (isset($request['type']) && $request['type'] != ''){

            /* Request type: List of the games and their price status */
            if ($request['type'] == 'list'){
                $id = 0;
                foreach ($data as $key => $game){
                    $auctionData = GetAuctionData($game['gameID']);
                    $priceLowEnough = IsPriceLowEnough($auctionData['price'], $game['notificationLimit']);
                    $result[] = [
                        'id' => $id,
                        'gameName' => $game['gameName'],
                        'isPriceLowEnough' => $priceLowEnough
                    ];
                    $id++;
                }

                /* Request type: all data for one game */
            } elseif ($request['type'] == 'detail' && isset($request['id']) && $request['id'] != ''){
                $game = $data[intval($_GET['id'])];
                $auctionData = GetAuctionData(intval($game['gameID']));
                $priceLowEnough = IsPriceLowEnough($auctionData['price'], $game['notificationLimit']);
                $result = [
                    'gameName' => $game['gameName'],
                    'gamePrice' => floatval($auctionData['price']),
                    'gameURL' => $game['gameURL'],
                    'sellerRating' => $auctionData['rating'],
                    'sellerSells' => $auctionData['sells'],
                    'sellerCountry' => $auctionData['country'],
                    'notificationLimit' => $game['notificationLimit'],
                ];
            }
        }
    }
}
header('Content-Type: application/json');
header('Cache-Control: no-cache');
header('Access-Control-Allow-Origin: *');
echo json_encode($result, JSON_UNESCAPED_UNICODE);
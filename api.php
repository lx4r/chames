<?php
require_once('config.php');
require_once('utils/get_game_data.php');
require_once('utils/data_management.php');

//http://stackoverflow.com/questions/18382740/cors-not-working-php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


/* Prepare the data for the API call result */
$data = LoadData($config['dataFile']);
$result = array();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $request = json_decode(file_get_contents('php://input'), true);
    if (isset($request)){
        /* Check whether the API secret is valid */
        if ($config['apiSecret'] == $request['apiSecret']){

            /* Request type given? If yes: Differ between request types */
            if (isset($request['type']) && $request['type'] != ''){


                /* Request type: List of the games and their price status */
                if ($request['type'] == 'list'){
                    /* Check whether any games exist */
                    if (count($data) > 0){
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
                    } else {
                        $result = ['error' => 'noGames'];
                    }

                    /* Request type: all data for one game */
                } elseif ($request['type'] == 'detail' && isset($request['id'])){

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
                        'notificationLimit' => $game['notificationLimit']
                    ];
                }
            } else {
                $result = ['error' => 'request'];
            }
        }
    } else {
        $result = ['error' => true];
    }
}
header('Content-Type: application/json');
header('Cache-Control: no-cache');
header('Access-Control-Allow-Origin: *');
echo json_encode($result, JSON_UNESCAPED_UNICODE);
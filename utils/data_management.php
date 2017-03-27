<?php

define('chames', true);

/*
 * structure in the JSON file for each game:
 * 'gameName' (String)
 * 'gameID' (int)
 * 'gameURL' (String)
 * 'notificationLimit' (double)
 * 'active' (boolean)
 * 'lowestPrice' (double)
 */

/* Load the games' data from the PHP/JSON file and return it */
function LoadData($file){
    $data = explode('?>', file_get_contents($file));
    if (isset($data[1])){
        return json_decode($data[1], true, 512, JSON_UNESCAPED_UNICODE);
    } else {
        return false;
    }
}

/* Save the games' data to the json file */
function SaveData($file, $newData){
    $data = '<?php if (!defined(\'chames\')) exit() ?>' . json_encode($newData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    return file_put_contents($file, $data);
}


?>

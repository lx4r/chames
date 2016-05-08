<?php

/*
 * structure in the JSON file for each game:
 * 'gameName' (String)
 * 'gameID' (int)
 * 'notificationLimit' (double)
 * 'active' (boolean)
 */

/* Load the games' data from the JSON file and return it */
function LoadData($file){
    return json_decode(file_get_contents($file), true, 512, JSON_UNESCAPED_UNICODE);
}

/* Save the games' data to the json file */
function SaveData($file, $newData){
    return file_put_contents($file, json_encode($newData, JSON_UNESCAPED_UNICODE));
}



?>
<?php

/*
 * structure in the JSON file for each game:
 * 'gameName' (String)
 * 'gameID' (int)
 * 'notificationLimit' (double)
 * 'active' (boolean)
 */

function LoadData($file){
    return json_decode(file_get_contents($file), true, 512, JSON_UNESCAPED_UNICODE);
}
function SaveData($file, $newData){
    return file_put_contents($file, json_encode($newData, JSON_UNESCAPED_UNICODE));
}
?>
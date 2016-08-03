<?php
function GetAuctionData($gameID){
    $data = json_decode(file_get_contents('https://www.g2a.com/marketplace/product/auctions/?id=' . $gameID), true);
    $data = array_values(array_values($data)[0])[0];
    $result = array();
    $result['price'] = $data['p'];
    $result['rating'] = $data['r'];
    $result['sells'] = $data['tr'];
    $result['country'] = GetCountry($data['c']);
    return $result;
}

function GetCountry($code){
    $data = json_decode(file_get_contents('http://restcountries.eu/rest/v1/alpha/' . $code), true);
    return $data['name'];
}
function GetLowestPrice($gameID){
    $data = GetAuctionData($gameID);
    return $data[0];
}

/* Finds a game's entity ID (needed for using the G2A API) by extracting it from the game's page on G2A */
function GetGameEntityID($gameURL){
    $gameSite = file_get_contents($gameURL);
    /* Find the game's ID in the page's HTML */
    preg_match("/(?<=productID = )(.*)(?=;)/", $gameSite, $entityID);
    if (count($entityID) >= 1){
        return $entityID[0];
    } else {
        return false;
    }
}
function IsPriceLowEnough($price, $limit){
    return $price <= $limit;
}
?>
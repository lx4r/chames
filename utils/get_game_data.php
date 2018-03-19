<?php
$AUCTION_DATA = array();
function GetAuctionData($gameID){
    if (isset($AUCTION_DATA[$gameID])) {
        return $AUCTION_DATA[$gameID];
    }
    $data = json_decode(file_get_contents('https://www.g2a.com/marketplace/product/auctions/?id=' . $gameID), true);
    if (isset($data['a'])) {
        $data = array_values(array_values($data)[0])[0];
        $result = array();
        $result['price'] = (float) $data['p'];
        $result['rating'] = $data['r'];
        $result['sells'] = $data['tr'];
        $result['country'] = GetCountry($data['c']);
        $result['currency'] = preg_replace("/^[0-9\., ]*/", "", $data['f']);
        $AUCTION_DATA[$gameID] = $result;
        return $result;
    } else {
        $AUCTION_DATA[$gameID] = false;
        return false;
    }
}

$COUNTRY_CODE_DATA = array();
function GetCountry($code){
    global $COUNTRY_CODE_DATA;
    if (isset($COUNTRY_CODE_DATA[$code])) {
	return $COUNTRY_CODE_DATA[$code];
    }
    $data = json_decode(file_get_contents('http://restcountries.eu/rest/v1/alpha/' . $code), true);
    $COUNTRY_CODE_DATA[$code] = $data['name'];
    return $data['name'];
}
function GetLowestPrice($gameID){
    $data = GetAuctionData($gameID);
    return ($data !== false ? $data['price'] : false);
}

/* Finds a game's entity ID (needed for using the G2A API) by extracting it from the game's URL on G2A */
function GetGameEntityID($gameURL){
    /* Find the game's ID in the page's URL */
    preg_match("/\d{14}/", $gameURL, $entityID);
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

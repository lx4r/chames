<?php
session_start();
require_once('config.php');
require_once('utils/logout.php');
require_once('utils/login_check.php');
require_once('utils/login.php');

if ($loggedIn){
    require_once('utils/get_game_data.php');
    require_once('utils/data_management.php');

    // Get the game data from the json file
    $data = LoadData($config['dataFile']);
    if ($data == false){
        $data = array();
    }

    $errors = array();

    // If the form is submitted ...
    if (isset($_POST['submit']) && $_POST['submit'] != ''){
        /* ... validate the input */
        if ($_POST["gameName"] == ''){
            $errors["gameName"] = true;
        }
        /* Chose preg_match because of random bugs with strpos */
        $URLContains = array();
        preg_match("/https:\/\/www.g2a.com\//", $_POST["gameURL"], $URLContains);
        if (($_POST["gameURL"] == '') || (count($URLContains) == 0)){
            $errors["gameURL"] = true;
        }

        if (($_POST["notificationLimit"] == '') || is_numeric($_POST["notificationLimit"]) == false){
            $errors["notificationLimit"] = true;
        }

        /* input successfully validated */
        if (count($errors) == 0){

            /* Get the current price of the game in order to fill the 'lowestPrice' field */
            $gameID = GetGameEntityID($_POST["gameURL"]);
            $lowestPrice = GetAuctionData($gameID)['price'];

            /* Add the new game to the game list array */
            $newEntry = array(
                'gameName' => $_POST['gameName'],
                'gameID' => GetGameEntityID($_POST["gameURL"]),
                'gameURL' => $_POST['gameURL'],
                'notificationLimit' => floatval($_POST['notificationLimit']),
                'active' => true,
                'lowestPrice' => $lowestPrice
            );
            array_push($data, $newEntry);
            /* and save it to the json file again */
            SaveData($config['dataFile'], $data);
            /* empty the form fields */
            $_POST['gameName'] = null;
            $_POST['gameURL'] = null;
            $_POST['notificationLimit'] = null;
        }
        // Remove a game from the array if a delete link is clicked and save the array to the json file again
    } elseif(isset($_GET['delete']) && $_GET['delete'] != '') {
        unset($data[intval($_GET['delete'])]);
        SaveData($config['dataFile'], $data);
        // Reactivate an alert in the array if a reactivate link is clicked and save the array to the json file again
    } elseif(isset($_GET['reactivate']) && $_GET['reactivate'] != ''){
        $data[intval($_GET['reactivate'])]['active'] = true;
        SaveData($config['dataFile'], $data);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <title>Chames</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-11 col-ms-12 col-xs-12">
            <h1>Chames
                <small>Your humble assistant to find cheap games</small>
            </h1>
        </div>
    </div>
    <?php
    if ($loggedIn) {
        if ($data){
            require_once ('views/game_list.php');
            /* Save the changes to the JSON file if the lowest price of a game has been updated */
            if ($changed){
                SaveData($config['dataFile'], $data);
            }
        }
        require_once ('views/add_game.php');
        require_once ('views/settings.php');
    } else {
        require_once('views/login_form.php');
    }
    require_once ('views/footer.php');
    ?>

</body>
</html>

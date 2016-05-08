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
    if ($data == null){
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
            /* Add the new game to the game list array */
            $newEntry = array(
                'gameName' => $_POST['gameName'],
                'gameID' => GetGameEntityID($_POST["gameURL"]),
                'notificationLimit' => intval($_POST['notificationLimit']),
                'active' => true
            );
            array_push($data, $newEntry);
            // ... and save it to the json file again
            SaveData($config['dataFile'], $data);
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

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
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
        ?>
        <div class="row">
            <div class="col-md-12 col-ms-12 col-xs-12">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>status</th>
                        <th>game</th>
                        <th>your limit</th>
                        <th>cheapest price</th>
                        <th>country of seller</th>
                        <th>rating of seller</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data as $key => $game) {
                        $auctionData = GetAuctionData($game['gameID']);
                        if ($auctionData['price'] <= $game['notificationLimit']) {
                            ?>
                            <tr class="success">
                        <?php } else { ?>
                            <tr>
                        <?php }
                        if ($game['active']) { ?>
                            <td><span class="text-success">active</span></td>
                        <?php } else { ?>
                            <td><span class="text-danger">disabled</span></td>
                        <?php } ?>

                        <td><?= $game['gameName'] ?></td>
                        <td><?= $game['notificationLimit'] ?></td>
                        <td><?= $auctionData['price'] ?></td>
                        <td><?= $auctionData['country'] ?></td>
                        <td><?= $auctionData['rating'] ?>% (based on <?= $auctionData['sells'] ?> sells)</td>
                        <td>
                            <a class="btn btn-danger btn-xs" href="?delete=<?= $key ?>"">delete</a>
                        </td>
                        <td>
                            <?php if ($game['active'] == false) { ?>
                                <a class="btn btn-primary btn-xs" href="?reactivate=<?= $key ?>">reactivate</a>
                            <?php } ?>
                        </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-ms-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Add a game</div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group<?php if (isset($errors["gameName"])) {echo " has-error";} ?>">
                                <label for="gameName">game name</label>
                                <input type="text" class="form-control" id="gameName" name="gameName"
                                       placeholder="Kerbal Space Program"
                                       value="<?php if (isset($_POST["gameName"])) echo $_POST["gameName"]; ?>"
                                       required>
                            </div>
                            <div class="form-group<?php if (isset($errors["gameURL"])) {echo " has-error";} ?>">
                                <label for="gameURL">game URL</label>
                                <input type="url" class="form-control" id="gameURL" name="gameURL"
                                       placeholder="https://www.g2a.com/kerbal-space-program-steam-cd-key-global.html"
                                       aria-describedby="URLHelp"
                                       value="<?php if (isset($_POST["gameURL"])) echo $_POST["gameURL"]; ?>" required>
                                <p id="URLHelp" class="help-block">URL of the game's page on g2a.com (including
                                    "https://")</p>
                            </div>
                            <div class="form-group<?php if (isset($errors["notificationLimit"])) {echo " has-error";} ?>">
                                <label for="notificationLimit">notification price limit</label>
                                <input type="number" step="any" min="0" class="form-control" id="notificationLimit"
                                       name="notificationLimit" placeholder="10" aria-describedby="limitHelp"
                                       value="<?php if (isset($_POST["notificationLimit"])) echo $_POST["notificationLimit"]; ?>"
                                       required>
                                <p id="limitHelp" class="help-block">When the game is available for this price or less
                                    an email will be sent to you.</p>
                            </div>
                            <input class="btn btn-success" type="submit" name="submit" value="Add">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-ms-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Your settings</div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>Email</td><td><?= $config['userEmail'] ?></td>
                            </tr>
                            <tr>
                                <td>Sender email</td><td><?= $config['senderEmail'] ?></td>
                            </tr>
                            <tr>
                                <td>Email subject</td><td><?= $config['emailSubject'] ?></td>
                            </tr>
                            <tr>
                                <td>Email subject</td><td><small><?= $config['emailText'] ?></small></td>
                            </tr>
                        </table>
                        <small>These settings and your password can be changed by edititing <code>config.php</code>.</small>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        require_once('views/login_form.php');
    }
    ?>

    <div class="row">
        <div class="col-md-11 col-ms-12 col-xs-12">
            <p class="text-muted">
                This software is not in any way affiliated with g2a.com.<br>
                <a href="https://github.com/lx4r/g2a-price-alert">Chames</a> by <a href="https://l3r.de">l3r</a>
            </p>
        </div>
        <?php
        if ($loggedIn){
            ?>
            <div class="col-md-1 col-ms-12 col-xs-12">
                <form method="post">
                    <input class="btn btn-danger btn-xs" type="submit" name="logout" value="Logout">
                </form>
            </div>
        <?php
        }
        ?>
    </div>
</div>

</body>
</html>

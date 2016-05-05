<?php
require_once('config.php');
require_once('get_game_data.php');
require_once('data_management.php');
// Get the game data from the json file
$data = LoadData($configDataFile);
if ($data == null){
    $data = array();
}

// If the form is submitted add the new game to the game list array ...
if (isset($_POST['submit']) && $_POST['submit'] != ''){
    $newEntry = array(
        'gameName' => $_POST['gameName'],
        'gameID' => intval($_POST['gameID']),
        'notificationLimit' => intval($_POST['notificationLimit']),
        'active' => true
    );
    array_push($data, $newEntry);
    // ... and save it to the json file again
    SaveData($configDataFile, $data);
    // Remove a game from the array if a delete link is clicked and save the array to the json file again
} elseif(isset($_GET['delete']) && $_GET['delete'] != '') {
    unset($data[intval($_GET['delete'])]);
    SaveData($configDataFile, $data);
    // Reactivate an alert in the array if a reactivate link is clicked and save the array to the json file again
} elseif(isset($_GET['reactivate']) && $_GET['reactivate'] != ''){
    $data[intval($_GET['reactivate'])]['active'] = true;
    SaveData($configDataFile, $data);
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
        <div class="col-md-10 col-ms-12 col-xs-12 col-md-offset-1">
            <h1>Chames</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-ms-12 col-xs-12 col-md-offset-1">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>status</th>
                    <th>game</th>
                    <th>cheapest price</th>
                    <th>country of seller</th>
                    <th>rating of seller</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data as $key => $game){
                    $auctionData = GetAuctionData($game['gameID']);
                    if ($auctionData['price'] <= $game['notificationLimit']){
                        ?>
                        <tr class="success">
                    <?php } else { ?>
                        <tr>
                    <?php }
                    if ($game['active']){ ?>
                        <td><span class="text-success">active</span></td>
                    <?php } else {?>
                        <td><span class="text-danger">disabled</span></td>
                    <?php } ?>

                    <td><?= $game['gameName']?></td>
                    <td><?= $auctionData['price'] ?></td>
                    <td><?= $auctionData['country'] ?></td>
                    <td><?= $auctionData['rating'] ?>% (based on <?= $auctionData['sells'] ?> sells)</td>
                    <td>
                        <a class="btn btn-danger btn-xs" href="?delete=<?= $key ?>"">delete</a>
                    </td>
                    <td>
                        <?php if ($game['active'] == false){ ?>
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
        <div class="col-md-6 col-ms-12 col-xs-12 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Add a game</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="gameName">game name</label>
                            <input type="text" class="form-control" id="gameName" name="gameName" placeholder="Kerbal Space Program" required>
                        </div>
                        <div class="form-group">
                            <label for="gameID">game entity_id</label>
                            <input type="number" class="form-control" id="gameID" name="gameID" placeholder="4422" aria-describedby="idHelp" required>
                            <p id="idHelp" class="help-block">Can be obtained by searching for "entity_id" in the source code of the game's page on g2a.com.</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">notification price limit</label>
                            <input type="number" step="any" min="0" class="form-control" id="notificationLimit" name="notificationLimit" placeholder="10" aria-describedby="limitHelp" required>
                            <p id="limitHelp" class="help-block">When the game is available for this price or less an email will be sent to you.</p>
                        </div>
                        <input class="btn btn-success" type="submit" name="submit" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-ms-12 col-xs-12 col-md-offset-1">
            <p class="text-muted">
                This software is not in any way affiliated with g2a.com.<br>
                <a href="https://github.com/lx4r/g2a-price-alert"> G2A price alert</a> by <a href="https://l3r.de">l3r</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>

<?php
require_once('config.php');
require_once('get_game_data.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <title>G2A price alert</title>
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
            <h1>G2A price alert</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-ms-12 col-xs-12 col-md-offset-1">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>game</th>
                    <th>cheapest price</th>
                    <th>country of seller</th>
                    <th>rating of seller</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($configGames as $game){
                    $auctionData = GetAuctionData($game['id']);
                    if ($auctionData['price'] <= $game['notificationLimit']){
                        ?>
                        <tr class="success">
                    <?php } else { ?>
                        <tr> <?php } ?>
                    <td><?= $game['name']?></td>
                    <td><?= $auctionData['price'] ?></td>
                    <td><?= $auctionData['country'] ?></td>
                    <td><?= $auctionData['rating'] ?>% (based on <?= $auctionData['sells'] ?> sells)</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-ms-12 col-xs-12 col-md-offset-1">
            <p class="text-muted">
                This software is not in any way affiliated with g2a.com<br>
                by <a href="https://l3r.de">l3r</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>

<?php
if (isset($_POST['password']) && $_POST['password'] != ''){
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $sessionSecret = '';
    $length = 25;
    for ($i = 0; $i < $length; $i++) {
        $sessionSecret .= $characters[rand(0, $charactersLength - 1)];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0">
        <title>Setup Chames</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-ms-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="password">New password</label>
                            <input type="password" class="form-control" id="passowrd" name="password" required>
                        </div>
                        <input class="btn btn-success" type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($passwordHash)) {?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-ms-12 col-xs-12">
                <div class="panel panel-success">
                    <div class="panel-body">
                        Please set the settings for the session secret and your password in <code>config.php</code> to this values:<br>
                        <code>'sessionSecret' => '<?= $sessionSecret ?>',</code><br>
                        <code> 'rightPasswordHash' => '<?= $passwordHash ?>',</code>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
</div>
</body>
</html>
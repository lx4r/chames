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
                               placeholder="https://www.g2a.com/kerbal-space-program-steam-key-global-i10000014989005"
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

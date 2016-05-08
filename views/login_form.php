<div class="row">
    <div class="col-md-4 col-ms-12 col-xs-12 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post">
                    <div class="form-group <?php if ($errorWrongPassword) {echo " has-error";} ?>">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <input class="btn btn-success btn-block" type="submit" name="submitPassword" value="Login">
                </form>
            </div>

        </div>
    </div>
</div>
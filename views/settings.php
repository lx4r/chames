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
                        <td>Email text</td><td><small><?= $config['emailText'] ?></small></td>
                    </tr>
                </table>
                <small>These settings and your password can be changed by edititing <code>config.php</code>.</small>
            </div>
        </div>
    </div>
</div>
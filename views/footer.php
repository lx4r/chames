<div class="row">
    <div class="col-md-12 col-ms-12 col-xs-12">
        <hr>
    </div>

    <div class="row">
        <div class="col-md-11 col-ms-12 col-xs-12">
            <p class="text-muted">
                This software is not in any way affiliated with g2a.com.<br>
                <a href="https://github.com/lx4r/chames">Chames</a> by <a href="https://l3r.de">lx4r</a> and awesome contributors
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

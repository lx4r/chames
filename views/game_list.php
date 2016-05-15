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

                <td><a href="<?= $game['gameURL'] ?>"><?= $game['gameName'] ?></a></td>
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
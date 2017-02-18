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
            $changed = false;
            foreach ($data as $key => $game) {
                $auctionData = GetAuctionData($game['gameID']);

                if ($auctionData === false) {
                    ?>
                    <tr>
                        <td><span class="text-danger">unavailable</span></td>
                        <td><a target="_blank" href="<?= $game['gameURL'] ?>"><?= $game['gameName'] ?></a></td>
                        <td><?= sprintf('%.2f', $game['notificationLimit']) ?></td>
                        <td><b>-</b></td>
                        <td>-</td>
                        <td>-</td>
                        <td><a class="btn btn-danger btn-xs" href="?delete=<?= $key ?>">delete</a></td>
                        <td>
                            <?php if ($game['active'] == false) { ?>
                            <a class="btn btn-primary btn-xs" href="?reactivate=<?= $key ?>">reactivate</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                    continue;
                }

                /* If the saved lowest price is higher than the current price replace it with the current price and then save the changes to the JSON file (done in index.php) */
                if ($game['lowestPrice'] == null || $game['lowestPrice'] > $auctionData['price']){
                    $data[$key]['lowestPrice'] = $auctionData['price'];
                    $changed = true;
                }

                if ($game['lowestPrice'] == $auctionData['price']){
                    $lowest = "lowest yet";
                } else {
                    $lowest = "lowest: " . sprintf('%.2f %s', $game['lowestPrice'], $auctionData['currency']);
                }

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

                <td><a target="_blank" href="<?= $game['gameURL'] ?>"><?= $game['gameName'] ?></a></td>
                <td><?= sprintf('%.2f %s', $game['notificationLimit'], $auctionData['currency']) ?></td>
                <td><b><?= sprintf('%.2f %s', $auctionData['price'], $auctionData['currency']) ?></b> (<?= $lowest ?>)</td>
                <td><?= $auctionData['country'] ?></td>
                <td><?= $auctionData['rating'] ?>% (based on <?= $auctionData['sells'] ?> sells)</td>
                <td>
                    <a class="btn btn-danger btn-xs" href="?delete=<?= $key ?>">delete</a>
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


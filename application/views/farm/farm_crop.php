<style>
    p {
        margin: 2px;
        padding: 0;
    }
</style>
<section id="farm_crop" style="width: 100%">
    <?php if (!$crops_info) { ?>
        <p>取引品を登録してください。</p>
        <p><input type="button" value="등록하기" onclick="location.href='/Farm/cropWrite'"></p>
    <?php } else { ?>
        <p>
            <a href="/Farm/farmCropMode/1">登録↑</a> /
            <a href="/Farm/farmCropMode/2">登録↓</a> /
            <a href="/Farm/farmCropMode/3">品名↑</a> /
            <a href="/Farm/farmCropMode/4">品名↓</a> /
            <a href="/Farm/farmCropMode/5">残量↑</a> /
            <a href="/Farm/farmCropMode/6">残量↓</a>
            <button onclick="location.href='/Farm/cropWrite'"
                    style="background: #2F9D27; border-radius: 0.3em; font-size: 85%; padding: 5px; float: right">登録
            </button>
        </p>
        <br><br>
        <div style="width: 100%">
            <?php
            foreach ($crops_info as $row) { ?>
                <div style="width: 25%; float: left; padding: 5px;">
                    <div align="center" style="margin-bottom: 100px">
                        <p><img
                                src="/public/assets/img/crops/<?= $row->cpname ?>" height="200" width="200"
                                style="border-radius: 30px; padding-bottom: 20px; cursor:pointer;" onclick="location.href='/Farm/cropDetail/<?= $row->cno ?>'"></p>
                        <div align="left" style="padding-left: 16%">
                            <p>品名 : <?= $row->cname ?></p>
                            <p>販売期間 : <?= $row->charvest ?></p>
                            <p>残量：<?= $row->cstock ?></p>
                        </div>
                        <form name="crop_stock_form" method="post" action="/Farm/cropStockUP">
                            <input type="hidden" name="cno" value="<?= $row->cno ?>">
                            <p>
                                <input type="number" name="cstock" value="0" style="width: 120px; height: 25px">&nbsp
                                <input type="submit" name="submit_crop_stock" value="残量増加"
                                       style="background: #2F9D27; border-radius: 0.2em; font-size: 85%; padding: 3px">
                            </p>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</section>
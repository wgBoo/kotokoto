<section id="farm_hope_detail">
    <div>
        <table align="center" style="margin: 0 auto">
            <tr align="center">
                <td rowspan="3" style="padding: 10px;"><img src="/public/assets/img/crops/<?= $corder_info->cpname ?>" width="200px" height="200px"></td>
                <td style="padding-left: 15px; padding-right: 15px;"><?= $corder_info->cname ?></td>
                <td rowspan="3" style="padding-left: 15px; padding-right: 15px;">
                    <?php if($corder_info->costatus == 0) { ?>
                        <img src="/public/assets/img/corder/corder0.png" width="800px" height="120px">
                    <?php } else if($corder_info->costatus == 1) { ?>
                        <img src="/public/assets/img/corder/corder1.png" width="800px" height="120px">
                    <?php } else if($corder_info->costatus == 5) { ?>
                        <img src="/public/assets/img/corder/corder1-1.png" width="800px" height="120px">
                    <?php } else if($corder_info->costatus == 2) { ?>
                        <img src="/public/assets/img/corder/corder2.png" width="800px" height="120px">
                    <?php } else if($corder_info->costatus == 3) { ?>
                        <img src="/public/assets/img/corder/corder3.png" width="800px" height="120px">
                    <?php } else { ?>
                        <img src="/public/assets/img/corder/corder4.png" width="800px" height="120px">
                    <?php }  ?>
                </td>
            </tr>
            <tr align="center"><td style="padding-left: 15px; padding-right: 15px;">残量 : <?= $corder_info->cstock ?> kg</td></tr>
            <tr align="center"><td style="padding-left: 15px; padding-right: 15px;">注文量 : <?= $corder_info->costock ?> kg</td></tr>
            <tr align="center"><td colspan="3" style="padding-top: 50px; padding-bottom: 50px">
                    <?php if($corder_info->costatus == 0) { ?>
                        <button style="background: #2F9D27; border-radius: 0.3em; font-size: 100%;" onclick="location.href='/Farm/order_ing/<?= $corder_info->cono ?>'">ボタンを押したら取引を受けます。</button>&nbsp&nbsp&nbsp&nbsp
                        <button style="background: #363636; border-radius: 0.3em; font-size: 100%;" onclick="location.href='/Farm/order_ing_fail/<?= $corder_info->cono ?>'">取引ができない場合押してください。</button>
                    <?php } else if($corder_info->costatus == 1) { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">入金を待っています。</button>
                    <?php } else if($corder_info->costatus == 2) { ?>
                        <button style="background: #2F9D27; border-radius: 0.3em; font-size: 100%;" onclick="location.href='/Farm/order_ing/<?= $corder_info->cono ?>'">発送してから押してください。</button>
                    <?php } else if($corder_info->costatus == 3) { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">発送中</button>
                    <?php } else if($corder_info->costatus == 5) { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">取引中止</button>
                    <?php } else { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">終了</button>

                    <?php } ?>
                </td></tr>
        </table>
    </div>
    <div>
        <form action="/Farm/writeContent" method="post">
            <input type="hidden" name="cono" value="<?= $corder_info->cono ?>">
            <textarea name="comcontent" rows="3" style="overflow-y:scroll; resize:none;"></textarea>
            <p align="right"><input type="submit" value="作成" style="background: #2F9D27; border-radius: 0.2em; font-size: 80%;"></p>
        </form>
    </div>
    <div>
        <?php foreach($message_info as $row) { ?>
        <form>
            <div style="float: left"><?= $row->uid ?></div><div style="float: right">日 : <?= $row->comday ?></div>
            <textarea disabled style="resize:none; width: 100%"><?= $row->comcontent ?></textarea>
        </form>
            <br>
        <?php } ?>

    </div>
</section>
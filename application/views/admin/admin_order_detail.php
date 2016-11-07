<section id="admin_order_detail">
    <div style="text-align: center">
        <h2>現況</h2><br><br>
        <table align="center" style="margin: 0 auto">
            <tr align="center">
                <td rowspan="4" style="padding: 10px;"><img style="border-radius: 20px" src="/public/assets/img/crops/<?= $corder_info->cpname ?>" width="200px" height="200px"></td>
                <td style="padding-left: 15px; padding-right: 15px;"><?= $corder_info->cname ?></td>
                <td rowspan="4" style="padding-left: 15px; padding-right: 15px;">
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
            <tr align="center"><td style="padding-left: 15px; padding-right: 15px;">残り量 : <?= $corder_info->mstock ?> kg</td></tr>
            <tr align="center"><td style="padding-left: 15px; padding-right: 15px;">注文量 : <?= $corder_info->costock ?> kg</td></tr>
            <tr align="center"><td style="padding-left: 15px; padding-right: 15px;">連絡先<br> <?= $corder_info->fphone ?></td></tr>
            <tr align="center"><td colspan="3" style="padding-top: 50px; padding-bottom: 50px">
                    <?php if($corder_info->costatus == 0) { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">取引先への確認中</button>
                    <?php } else if($corder_info->costatus == 1) { ?>
                        <button style="background: #2F9D27; border-radius: 0.3em; font-size: 100%;" onclick="location.href='/Admin/order_ing/<?= $corder_info->cono ?>'">代金を入金してください</button>
                    <?php } else if($corder_info->costatus == 2) { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">発送の準備</button>
                    <?php } else if($corder_info->costatus == 3) { ?>
                        <button style="background: #2F9D27; border-radius: 0.3em; font-size: 100%;" onclick="location.href='/Admin/order_ing/<?= $corder_info->cono ?>'">届いたらボタンを押して確認してください</button>
                    <?php } else if($corder_info->costatus == 5) { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">引先からへの中止</button>
                    <?php } else { ?>
                        <button disabled style="background: #BDBDBD; border-radius: 0.3em; font-size: 100%;">終了</button>
                    <?php } ?>
                </td></tr>
        </table>
    </div>
    <div>
        <br><h3>メッセージ</h3><br>
        <form action="/Admin/writeContent" method="post">
            <input type="hidden" name="cono" value="<?= $corder_info->cono ?>">
            <textarea name="comcontent" style=" resize:none; min-height: 100px"></textarea>
            <p align="right"><input type="submit" value="作成" style="background: #2F9D27; border-radius: 0.2em; font-size: 80%;"></p>
        </form>
    </div>
    <div>
        <?php foreach($message_info as $row) { ?>
            <form>
                <div style="float: left"><?= $row->uid ?></div><div style="float: right">日 : <?= $row->comday ?></div>
                <textarea disabled style="resize:none; min-height: 100px;"><?= $row->comcontent ?></textarea>
            </form>
            <br>
        <?php } ?>
    </div>
</section>
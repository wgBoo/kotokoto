<section id="farm">
    <?php if (!$farm_info) { ?>
        <p>生産地の紹介を登録してください。</p>
        <input type="button" value="登録する" onclick="location.href='/Farm/farmWrite'">
    <?php } else { ?>
        <div style="margin: 0 auto; margin-top: 100px;">
                <table>
                    <tr>
                        <td rowspan="4" width="450" height="350"><img id="Uploadedimg" src="../public/assets/img/farm/<?= $farm_info->fpname ?>" width="350"
                                             height="350" style="border-radius: 50px"></td>
                        <td width="100">生産地名</td><td><span style="text-align: center">[ <?= $farm_info->fname ?> ]</span></td>
                    </tr>
                    <tr>
                        <td>名前</td><td><span style="text-align: center">[ <?= $farm_info->farmer ?> ]</span></td>
                    </tr>
                    <tr>
                        <td>住所</td><td><span style="text-align: center;"><?= $farm_info->flocation ?></span></td>
                    </tr>
                    <tr><td>紹介</td><td><textarea name="fintro" rows="5" cols="80" readonly class="block" style="resize: none;"><?= $farm_info->fintro ?></textarea></td></tr>
                </table>
                <p style="float: right;"><input type="button" value="수정" onclick="location.href='/Farm/farmModify'"></p>
        </div>
    <?php } ?>
</section>
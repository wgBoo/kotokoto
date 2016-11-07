<section id="crop_detail">
    <div style="margin: 0 auto; margin-top: 100px;">
        <table>
            <tr>
                <td rowspan="4" width="450" height="350"><img id="Uploadedimg" src="/public/assets/img/crops/<?= $crop_info->cpname ?>"
                                     width="350" height="350" style="border-radius: 50px"></td>
                <td width="100">品名</td><td><span style="text-align: center">[ <?= $crop_info->cname ?> ]</span></td>
            </tr>
            <tr>
                <td>残量</td><td><span style="text-align: center">[ <?= $crop_info->cstock ?> ]</span></td>
            </tr>
            <tr>
                <td>取引の期間</td><td><span style="text-align: center;">[ <?= $crop_info->charvest ?> ]</span>
                </td>
            </tr>
            <tr><td>紹介</td><td><textarea name="fintro" rows="5" cols="80" readonly class="block" style="resize: none;"><?= $crop_info->cintro ?></textarea></td></tr>
        </table>
        <p style="float: right">
            <input type="button" value="修正" onclick="location.href='/Farm/cropsModify/<?= $crop_info->cno ?>'" style="margin-right: 20px">
            <input type="button" value="削除" onclick="location.href='/Farm/cropsDelete/<?= $crop_info->cno ?>'">
        </p>
    </div>
</section>
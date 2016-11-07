<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#Uploadedimg').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<section id="crop_modify">
    <form name="crops_modify_form" method="post" action="/Farm/cropModifyDB" encType="multipart/form-data">
        <input type="hidden" name="cno" value="<?= $crop_info->cno ?>">
        <table>
            <tr>
                <td rowspan="2"><img id="Uploadedimg" src="/public/assets/img/crops/<?= $crop_info->cpname ?>"
                                     width="133" height="133"></td>
                <td>品名 <input type="text" name="cname" value="<?= $crop_info->cname ?>"></td>
            </tr>
            <tr>
                <td>残量 <input type="number" name="cstock" value="<?= $crop_info->cstock ?>"></td>
            </tr>
            <tr>
                <td><input type="file" name="picName" onchange="readURL(this);"></td>
                <td>取引の期間 <input type="text" name="charvest" value="<?= $crop_info->charvest ?>"></td>
            </tr>
        </table>
        <div>
            <p>紹介</p>
            <textarea name="cintro" rows="5"><?= $crop_info->cintro ?></textarea>
        </div>
        <p><input type="submit" name="submit_crop_modify" value="修正する"><input type="button" value="キャンセル"
                                                                           onclick="location.href='/Farm/farmCrop'"></p>
    </form>
</section>
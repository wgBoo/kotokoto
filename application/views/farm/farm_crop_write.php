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
<section id="crop_write">
    <form name="crops_write_form" method="post" action="/Farm/cropWriteDB" encType="multipart/form-data">
        <input type="hidden" name="fno" value="<?= $farm_info->fno ?>">
        <table>
            <tr>
                <td rowspan="2"><img id="Uploadedimg" src="../public/assets/img/default.jpg"
                                     width="133" height="133"></td>
                <td>品名 <input type="text" name="cname" placeholder="品名を入力してください。"></td>
            </tr>
            <tr>
                <td>残量 <input type="number" name="cstock" value="0"></td>
            </tr>
            <tr>
                <td><input type="file" name="picName" onchange="readURL(this);"></td>
                <td>取引の期間 <input type="text" name="charvest" placeholder="取引の期間を入力してください。"></td>
            </tr>
        </table>
        <div>
            <p>紹介</p>
            <textarea name="cintro" placeholder="紹介を入力してください。" rows="5"></textarea>
        </div>
        <p><input type="submit" name="submit_crop_write" value="登録する"><input type="button" value="キャンセル"
                                                                           onclick="location.href='/Farm/farmCrop'"></p>
    </form>
</section>
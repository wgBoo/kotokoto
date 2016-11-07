<style>

    form select{
        width: 20%;
    }

</style>
<script>
    /*$(document).ready(function () {
        for (var i = 1; i < num; i++) {
            $("#picked" + i).change(function () {
                var selected = $(this).val();
                console.log(selected);
                console.log(i);
                if (selected) {
                    $("#comment" + i).hide();
                }
                else {
                    $("#comment" + i).show();
                }
            });
        }
    });*/
</script>

<link href="/public/assets/css/image-picker.css" rel="stylesheet">
<script src="/public/assets/js/image-picker.min.js"></script>
<div class="8u 12u(mobile) important(mobile)" id="content">
    <article id="main">
        <section>

            <h3><font color="red">写真と文修正</font><br/>
                (写真をクリックするとそのページを削除することができます)</h3>
            <hr>
            <form action="/Mypage/diary_modify/" method="post" enctype="multipart/form-data">
                <?php
                $i = 0;
                foreach ($diaryInfo as $row) {
                    $i++;
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                <select id="picked<?= $i ?>" name="diary_image[<?= $row->pcno ?>]"
                                        class="image-picker show-html" data-index="comment<?= $i ?>">
                                    <option value=''></option>
                                        <?php if(substr($row->pcname,0,1) == 'V'){ ?>
                                            <option data-img-src="/public/assets/video/<?= $row->pcname ?>"><?= $row->pcname ?>
                                            </option>
                                                <?php }else{ ?>
                                            <option data-img-src="/public/assets/img/diary/<?= $row->pcname ?>"><?= $row->pcname ?>
                                            </option>
                                                <?php } ?>
                                </select>
                            </p>
                            <p id="comment<?= $i ?>">
                                <textarea class="ckeditor"
                                          name="diary_comment[<?= $row->pcno ?>]"><?= $row->pccontent ?></textarea>
                            </p>

                            <p>

                            <h3 style="width: 600px; align-content: center" align="center"><?= $i + 5 ?>Page修正<h3>
                            </p>
                        </div>
                    </div>
                <?php }
                ?>
                <p style="width: 600px" align="center">
                    <button type="submit" class="btn btn-primary" name="diaryModify" value="modify">修正</button>&nbsp;
                    <button type="button" class="btn btn-danger" onclick="location.href='/Mypage/diary_info'">キャンセル
                    </button>
                </p>
            </form>
            <script>
                var num = '<?= $i ?>';
                $("select").imagepicker();
                //    $("select").css('display', 'inline'); select 글씨표시해주는것
            </script>


        </section>
    </article>
</div>

<script>
    $('.image_picker_selector').on('click', function() {
        var index = $(this).prev().attr('data-index');
        var select = $(this).find('div.thumbnail');
        var item = $('#'+index);

        if(select.hasClass('selected'))
            item.css('display', 'none');
        else
            item.css('display', 'inline');
    });
</script>
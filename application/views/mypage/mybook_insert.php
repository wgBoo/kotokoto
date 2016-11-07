<script>
    $(document).ready(function () {

        $(".thumbnail").hide();

        $("#video").change(function(){
            var selected = $(this).val();
            if(selected){
                $("#deleteX").attr("required",false);
            }else{
                $("#deleteX").attr("required",true);
            }
        });

        $("#deleteX").change(function(){
            var selected = $(this).val();
            if(selected){
                $("#video").attr("required",false);
            }else{
                $("#video").attr("required",true);
            }
        });

    });
    function galleryToggle()
    {
        $(".thumbnail").toggle("fast");
    }

</script>

<link href="/public/assets/css/image-picker-gallery.css" rel="stylesheet">
<script src="/public/assets/js/image-picker.min.js"></script>
<div class="8u 12u(mobile) important(mobile)" id="content">
    <article id="main">
        <section>
<h2>ダイアリー登録</h2>
<?php

if($orderStatus) { ?>
    <form action="/Mypage/diary_insert/" method="post" enctype="multipart/form-data">
    <?php if(isset($addDistinction)){ ?>
        <input type="hidden" name="addDistinction" value="<?= $addDistinction ?>">
    <?php }?>

    <select style="width: 25%;" name="no" required>
       <option value="">購買したレシピ</option>

<?php foreach($orderStatus as $row) {  ?>
    <option value ="<?= $row->rno.','.$row->ono ?>"><?= $row->rname ?></option>
        <?php } ?>
        </select >

        <br/>
        <br/>

        <!--
        <div>
            <button type="button" onclick="galleryToggle()" class="btn btn-primary" >Mygallery 사진등록</button>
            &nbsp;&nbsp;
            <select id="gallery" name="galleryImage[]" multiple="multiple" class="image-picker show-html">

            <?php /*foreach($gallery as $row){*/?>
                <option data-img-src = "/public/assets/img/diary/<?/*= $row */?>"><?/*= $row */?></option>
            <?php /*} */?>
        </select>
        </div>-->

        <div>
            <button style="background: #4174BA; cursor : default;" type="button" disabled>PC 映像 登録</button>
        </div>


        <?php
//        $selected = "<script>document.write(selected);</script>";
        ?>

        <p><input id="video" type="file" multiple name="diary_video[]" required></p>

        <button style="background: #4174BA; cursor : default;" disabled>PC 写真 登録</button>

        <p><input id="deleteX" type="file" multiple name="diary_image[]" required></p>
        <p><input style="background: rgba(252, 179, 83, 0.99);" type="submit" name="diary_write" value="作成">
            <input type="button" name=indate size=10 onclick="location.href='/Mypage/diary_Info'" value="キャンセル">
        </p>
        </form>

<?php } ?>

        </section>
    </article>
</div>
<script>
    $("#gallery").imagepicker({
        hide_select : true,
        show_label  : false
    })
</script>
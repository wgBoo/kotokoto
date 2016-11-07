<div class="8u 12u(mobile) important(mobile)" id="content">
    <article id="main">
        <section>
<h2>写真と文作成</h2>
<form name="insertForm" action="/Mypage/diary_insert_comment/" method="post" enctype="multipart/form-data">
    <?php
    if(isset($addDistinction)){ //요리일기 추가버튼을 눌렀으면
$i = 0;
foreach($diaryInfo as $row){
    for($j = 0 ; $j < count($addImageName); $j++){
    if($row->pcno == $addImageName[$j]){ //해당 다이어리전체 pcname중에서 추가한 이미지이름이 같으면
        $pcname[] = $row->pcname;
        ?>
    <div align="center" class="panel panel-default">
        <div class="panel-body">
            <p>
                <?php if(substr($row->pcname ,0,1) == 'V'){ ?>
                    <video class="video-js vjs-default-skin" controls preload="auto" width="400" height="300" data-setup="{}">
                        <source src='/public/assets/video/<?= $row->pcname  ?>' type='video/ogg' />
                    </video>
                <?php }else{ ?>
                    <img src="/public/assets/img/diary/<?= $row->pcname ?>" style="width:600px; height:280px;">
                <?php } ?>

            </p>
            <textarea class="ckeditor" name="diary_comment[<?= $row->pcno ?>]" placeholder="내용"></textarea>
            <p><h3><?= $i+6 ?>Page<h3></p> <!--6 이첫페이지니까-->

        </div>
    </div>

<?php }} $i++; }}else{
?>
    <?php
    $i = 0;

    foreach($diaryInfo as $row){
        $pcname[] = $row->pcname;
            ?>
            <div align="center" class="panel panel-default">
                <div class="panel-body">
                    <p>
                        <?php if(substr($row->pcname ,0,1) == 'V'){ ?>
                            <video class="video-js vjs-default-skin" controls preload="auto" width="400" height="300" data-setup="{}">
                                <source src='/public/assets/video/<?= $row->pcname  ?>' type='video/ogg' />
                            </video>
                        <?php }else{ ?>
                            <img src="/public/assets/img/diary/<?= $row->pcname ?>" style="width:600px; height:280px;">
                        <?php } ?>
                    </p>
                    <textarea class="ckeditor" name="diary_comment[<?= $row->pcno ?>]" placeholder="내용"></textarea>
                    <p><h3><?= $i+6 ?>Page<h3></p>
                </div>

            </div>

        <?php $i++; }}
    ?>
    <?php $_SESSION['pcname'] = $pcname ?>
    <p align="center"><button type="submit" class="btn btn-primary" name="insert_comment" value="insert">작성</button>
        <button type="button" class="btn btn-danger" onclick="location.href='/Mypage/cancelDelete/'">취소</button>
    </p>
</form>
        </section>
    </article>
</div>



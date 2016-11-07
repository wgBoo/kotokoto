<style>
    img {
        border-radius: 8px;
    }
</style>
<script>
    /*function displayon(id) {
        var display = document.getElementById(id);
        display.style.display = "inline";
    }
    $(document).ready(function () {
        console.log(document.getElementById("index0"));
        displaynone("index0");
    });*/

    /*function indexToggle() {
        var index = $(this).prev().attr('data-index');
        var select = $(this).find('div.thumbnail');
        var item = $('#'+index);

        if(select.hasClass('selected'))
            item.css('display', 'none');
        else
            item.css('display', 'inline');
    }*/

</script>

<!--video-->
<link href="http://vjs.zencdn.net/5.10.4/video-js.css" rel="stylesheet">

<!-- If you'd like to support IE8 -->
<script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

<!--내용을 먼저 쓰고 목차를 적는다-->
<?php
if ($diaryInfo) {
    ?>
    <?php for ($i = 0; $i < count($diaryInfo); $i++) { ?>
        <!--pdfcut-->
        <!--cutstart-->
        <div id="page<?= $i + 6 ?>">
            <div class="book-content">
                <!--cutend-->
                <?php
                if ($i) {
                    if (($diaryInfo[$i - 1]->dno) !== ($diaryInfo[$i]->dno)) {
                        $pageNum[] = $i + 6;
                        $rname[] = $diaryInfo[$i]->rname; //dno가 다른거부터 rname 저장
                        $dday[$i] = $diaryInfo[$i]->dday; //1이상일때 목차에서 보여질 날짜를 변수에 담기
                        ?>
                        <h2 align="center" style="font-family: TAKUMIYFONTMINI_P;font-size: 19px ;">*レシピ: <?= $diaryInfo[$i]->rname ?> /
                            <?php

                                $sttime = strtotime($diaryInfo[$i]->dday);
                                $day = date("y-m-d", $sttime);
                                echo ' '.$day;
                            
                           ?>* </h2>
                    <?php }
                } else {
                    ?>
                    <?php
                    $stttime = strtotime($diaryInfo[0]->dday);
                    $day = date("y-m-d", $stttime);
                    $dday[0] = $day; //0일때 목차에서 보여질 날짜를 변수에담기
                    ?>
                    <h2 align="center" style="font-family: TAKUMIYFONTMINI_P; font-size: 19px">*レシピ: <?= $diaryInfo[0]->rname ?> / <?= $day ?>* </h2>
                <?php } ?>
                <p class="center-pic">
                    <!--파일이 동영상이면-->
                    <?php if (substr($diaryInfo[$i]->pcname, 0, 1) == 'V') { ?>
                        <video class="video-js vjs-default-skin" controls preload="auto" width="400" height="200" data-setup="{}">
                            <source src='/public/assets/video/<?= $diaryInfo[$i]->pcname ?>' type='video/ogg'/>
                        </video>
                    <?php } else { ?>
                        <img src="/public/assets/img/diary/<?= $diaryInfo[$i]->pcname ?>"
                             style="width:350px; height:230px; border-radius: 8px;">
                    <?php } ?>
                </p>
                <!--cutstart--><?= $diaryInfo[$i]->pccontent?><!--cutend-->

                <!--cutstart-->
            </div>
            <span class="page-number" style="font-size: 15px"><?= $i + 6 ?></span><!---->
        </div><!--cutend-->

    <?php } ?>


    <!--목차작성-->
    <!--pdfcut-->

    <!--cutstart-->
    <div id="page5">

        <div class="table-contents">
            <!--cutend-->

            <h1 align="center" style="font-family: 'MS PGothic'">目次</h1>

            <?php
            //목차 날짜 추출
            if (isset($dday)) {
                $h = 0;
                foreach ($dday as $row) {
                    $sttime = strtotime($row);
                    $date[$h] = date("y/m/d", $sttime);
                    $h++;
                }
            }?>

            <!--날짜 구분해서 찍어주기-->
            <?php
            if (isset($pageNum)) { /*생성된 페이지가 2개이상 일때*/ ?>
                <!--첫번째인덱스실행(날짜 찍히는 부분)-->
                <h5 onclick="indexToggle(0);" style="cursor: pointer"><?= $date[0] ?></h5>
                        <ul id="index0" style="display: none">
                            <li><a href="#page/6"><?= $diaryInfo[0]->rname ?><!--cutstart--><span>6</span><!--cutend--></a></li>

               <?php for ($i = 0; $i < count($pageNum); $i++) { ?>

                            <!--루프를돌때 날짜가 다르면-->
                    <?php if ($date[$i+1] !== $date[$i]) { /*날짜가여러개라면 하나이상부터 날짜찍히는부분*/?>

                        </ul> <!--루프를돌다 날짜가 다르면 태그를 닫아준다-->
                        <h5 onclick="indexToggle(<?= $i+1 ?>);" style="cursor: pointer"><?= $date[$i+1] ?></h5>
                        <ul id="index<?= $i+1 ?>" style="display: none"> <!--두번째 날짜부터 다시ul열어줌-->
                            <li><a href="#page/<?= $pageNum[$i] ?>"><?= $rname[$i] ?><!--cutstart--><span><?= $pageNum[$i] ?></span><!--cutend--></a>
                            </li>

                    <?php }else{   /*다음루프를 돌때 날짜가 같은 글이면*/ ?>

                        <li><a href="#page/<?= $pageNum[$i] ?>"><?= $rname[$i] ?><!--cutstart--><span><?= $pageNum[$i] ?></span><!--cutend--></a>
                        </li>
                    <?php } ?>

                <?php } ?>

                <!--마지막 닫는 태그-->
                </ul>

           <?php } else { ?> <!--생성된 페이지가 1개 일때-->
                <h5 onclick="indexToggle(0);" style="cursor: pointer"><?= $date[0] ?></h5>
                <ul id="index0" style="display: none">
                    <li><a href="#page/6"><?= $diaryInfo[0]->rname ?><!--cutstart--><span>6</span><!--cutend--></a></li>
                </ul>
            <?php } ?>
            <!--cutstart-->
        </div>
        <!--cutstart--><span class="page-number" style="font-size: 15px">5</span><!--cutend-->
        <!--cutstart-->
    </div>
<?php } ?>
<!--pdfcut-->

<!--video-->
<script src="http://vjs.zencdn.net/5.10.4/video.js"></script>

<div class="8u 12u(mobile) important(mobile)" id="content">
    <article id="main">
        <section>

<p align="center"><button type="button" class="btn btn-danger" onclick="location.href='/Mypage/diary_insert_view/<?=$user_id ?>'">새요리일기등록</button>
</p>
<caption> 다이어리 리스트 </caption>
<?php

if($mybookList) {
    foreach($mybookList as $row)

    {?>
<table width = "600px" border = "1px">
    <tr>

        <td rowspan ="3"><a href="/Mypage/diary_Info/<?= $row->dno ?>"><img src="/public/assets/img/kimchi.jpg"></a></td>
        <td> 레시피명 : <?= $row->rname?></td>
    </tr>
    <tr>
        <td> 총 구매 횟수 : 1</td>
    </tr>
    <tr>
        <td> 작성일시 : <?= $row->dday ?></td>
    </tr>

</table>

<?php }}else{ ?>
    <h2>일기를 등록해 보세요~~!</h2>
<?php } ?>


        </section>
    </article>
</div>
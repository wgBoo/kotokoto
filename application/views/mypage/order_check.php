<div class="8u 12u(mobile) important(mobile)" id="content">
    <article id="main">
<div style="text-align: center; width: 100%">
      <h2>주문/배송조회</h2>
</div>
            <table border="1">
                <tr>
                    <td class="name">주문번호</td>
                    <td class="name">주문일자</td>
                    <td class="name">상품명</td>
                    <td class="name">주문금액</td>
                    <td class="name">상태</td>
                    <td class="name">배송조회</td>
                </tr>
            <?php foreach($orderList as $row){?>
                <tr>
                    <td><?= $row->ono ?></td>
                    <td><?= $row->oday ?></td>
                    <td><?= $row->rname?></td>
                    <td><?= $row->rprice?></td>
                    <td><?= $row->ostatus?></td>
                    <td><a href="#">조회</a></td>
                </tr>
            <?php } ?>

            </table>

    </article>
</div>
<style>
    .name{
        background-color: wheat;
    }
</style>
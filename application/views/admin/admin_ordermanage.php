<section id="admin_ordermagage">
    <div>
        <table border="1">
            <tr>
                <td>주문번호</td><td>주문내용</td><td>가격</td><td>배송지</td><td>상태</td><td>수령일</td>
            </tr>
            <?php foreach($order_list as $row) { ?>
                <tr>
                    <td><?= $row->ono ?></td>
                    <td></td>
                    <td><?= $row->oprice ?></td>
                    <td><?= $row->ad1 ?> <?= $row->ad2 ?> <?= $row->menstion ?></td>
                    <td><?= $row->ostatus ?></td>
                    <td><?= $row->owishday ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</section>
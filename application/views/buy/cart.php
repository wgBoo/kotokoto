<h1>장바구니 리스트</h1>
<table border="1" id="recipeadd">
    <tr>
        <td>레시피명</td>
        <td>수량</td>
        <td>가격</td>


    </tr>
    <?php foreach ($cartList as $cart) { ?>
        <tr>
            <td><?php echo $cart->rname ?></td>
            <td><input type="number" id="stock" value="<?php echo $cart->sstock ?>"></td>
            <td><?php echo $cart->sprice ?></td>


        </tr>
    <?php } ?>
</table>

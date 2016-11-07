<form method="post" action="/Admin/interestAdd">
    <input type="hidden" name="rno" value="<?php echo $rno ?>"
<div class="box">
    <div class="crops">
        <table border="1" id="recipeadd">
            <tr>
                <td>관심사 이름</td>
                <td>관심사 내용</td>
                <td>관심사 체크</td>
            </tr>
            <?php foreach ($interests as $interest) { ?>
                <tr>
                    <td>
                        <?php echo $interest->iname ?>
                    </td>
                    <td>
                        <?php echo $interest->icontent ?>
                    </td>
                    <td>
                        <input type="checkbox" name="ino[]" value="<?php echo $interest->ino ?>">
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <input type="submit" value="가자">
</div>
</form>
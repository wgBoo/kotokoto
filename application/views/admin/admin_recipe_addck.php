<h1>제외불가재료확인</h1>
<form method="post" action="/Admin/recipeAddCk">
    <div class="box">
      <input type="hidden" name="rno" value="<?php echo $rno ?>">

<?php foreach ($crops as $crop) { ?>
    <input type="hidden" name="checkCrops[]" value="<?php echo $crop->mno?>">

<?php }?>

        --<br>

        <div class="crops">
            <h3>사용재료</h3>
            <table border="1" id="recipeadd">
                <tr>
                    <td>
                        재료명
                    </td>
                    <td>
                        농장명
                    </td>
                    <td>
                        수량
                    </td>
                    <td>
                        제외불가여부
                    </td>
                </tr>
                <?php foreach ($crops as $crop) { ?>

                    <tr>
                        <td>
                            <?php echo $crop->cname; ?>
                        </td>
                        <td>
                            <?php echo $crop->fname; ?>
                        </td>
                        <td>
                            <input type="number" name="rmmstock[]" step="0.1" value="1">
                        </td>
                        <td>
                            <input type="checkbox" name="rmexclude[]" value="<?php echo $crop->mno?>">
                        </td>

                    </tr>
                <?php } ?>
            </table>
        </div>
        <input type="submit" value="가자">
    </div>
</form>
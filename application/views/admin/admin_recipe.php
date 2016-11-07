<div style="width: 100%; text-align: center">
<h2 style="margin-top: 2%; margin-bottom: 0" >레시피 관리</h2>
</div>
<div style="width: 100%">
<table style="margin: auto; width: 70%;" id="recipeadd">
    <tr>
        <td style="background-color: wheat">이미지</td>
        <td style="background-color: wheat">레시피 이름</td>
        <td style="background-color: wheat">조리시간</td>
        <td style="background-color: wheat">가격</td>
    </tr>
<?php foreach($recipeList as $recipe){  ?>
<tr>
    <td>
        <img width="100px" src="/public/assets/img/recipe/<?php echo $recipe->rpicture ?>">
    </td>
    <td>
       <?php echo $recipe->rname ?>
    </td>
    <td>
        <?php echo $recipe->rtime ?>
    </td>
    <td>
        <?php echo $recipe->rprice ?>
    </td>
</tr>
<?php }?>
</table>
</div>

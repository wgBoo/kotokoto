<h1>레시피 등록</h1>

<form method="post" action="/Admin/recipeAdd" encType="multipart/form-data">
    <div class="box">
        레시피명<input type="text" name="rname" width="100"><br>
        조리시간<input type="text" name="rtime"><br>
        가격<input type="text" name="rprice"><br>
        사진<input type="file" name="picName"><br>

        <div class="crops">
            <h3>재료목록</h3>
            <table border="1" id="recipeadd">
                <tr>
                    <td >작물명</td>
                    <td>농장명</td>

                    <td>사용재료</td>

                </tr>
                <?php foreach($crops as $crop){ ?>
                    <tr>
                        <td>
                            <?php echo $crop->cname; ?>
                        </td>
                        <td>
                            <?php echo $crop->fname; ?>
                        </td>


                        <td><input type="checkbox" name="checkCrops[]" value="<?php echo $crop->mno?>"></td>

                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <input type="submit" value="가자">
    </div>
</form>



<span class="car">dd</span>
<script>
    $("#add").click(function(){
        var i, t, tag= [], str = "", sum = 0;
        var cname = document.getElementsByName('cchk');
        var tot = cname.length;
        for(i = 0; i < tot; i++){
            if(cname[i].checked == true){
                tag[sum] = cname[i].value;
                sum++;
            }
        }
        str += tag.join(",");

        $.ajax({
            url:'../../admin/getCrop',
            dataType: 'json',
            type: 'post',
            data:{'cno':str},
            success: function(data){
                var tox = data.length;
                foss:=0; t < tox; t++){
            alert(data[t].cname)
        }

    }
    })
    });
</script>


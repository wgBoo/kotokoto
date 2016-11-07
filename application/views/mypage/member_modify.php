<style>
    form input[type="text"],
    form input[type="email"],
    form input[type="password"],
    form textarea {
        width: 40%;
    }
    form select {
        width: 25%;
    }

    p{
        margin-top: 10px;
        margin-bottom: 0px;
    }


</style>


<script type="text/javascript">
    //비밀번호확인이 다르면 alert!
    window.onload = function () {
        document.getElementById('modify').onsubmit = function () {
            var pass = document.getElementById('pw').value;
            var passCheck = document.getElementById('re_pw').value;

            if (!(pass == passCheck)) {
                alert('パスワードが違います！');
                return false;
            }
        };

        $.ajax({
            url : "/Member/ajax_listen",
            dataType: "json",
            success: function(data){
//                var content = jQuery.parseJSON(data);
                    for (var i = 0; i < data.length; i++) {
                        $('#example').append("<div id='item" + i + "'>" +
                            "<input name='interest[]' value=" + data[i]['iname'] + " readonly>" + "&nbsp;" +
                            "<button style='padding: 0.5em 0.9em 0.5em 0.9em' id='delBtn" + i + "' onclick='delete_content(" + i + ")'>削除</button></div>");
                    }

            },

            error:function(request, status, error){
                alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }

        });
    };


    $(document).ready(function () {
        // 옵션추가 버튼 클릭시
        $("#addItemBtn").click(function () {
            var interest = $('#interest option:selected').val();
            if(!interest){
                alert('関心事を選んでください!');
            }else {
                $('#example').append("<div id='item" + interest + "'><input name='interest[]' value=" + interest + " readonly>" + "&nbsp;<button style='padding: 0.5em 0.9em 0.5em 0.9em' class='delBtn" + interest + "'>削除</button></div>");
                // 삭제버튼 클릭시
                $(".delBtn" + interest).live("click", function () {
                    $('#item' + interest).remove();
                });
            }
        });

    });

    //사용자가 처음 입력한 관삼사 삭제시
    function delete_content(num){
        $('#item' + num).remove();
    }

    function memberLeave(){
        if(confirm("本当に'ことこと'を脱退しますか？" +
                "(脱退すると会員様の全ての情報が削除されます！)") == true){ //확인
            location.href='/Member/member_leave';
        }else{     //취소
            return;
        }
    }

</script>

<div class="8u 12u(mobile) important(mobile)" id="content">
    <article id="main">
        <div>
            <h1 style="font-size: x-large">会員情報修正</h1>

            <form id="modify" action="/Member/member_modify" method="post">
                <p>ID</p>
                <input type="text" value="<?= $memberModifyInfo[0]->uid ?>" readonly>

                <p id="toppadding">Password</p>
                <input type="password" name="pw" id="pw" required>

                <p>Password</p>
                <input type="password" name="re_pw" id="re_pw" required>

                <p>Email</p>
                <input type="email" name="email" value="<?= $memberModifyInfo[0]->email ?>">

                <p>Sex</p> <!--<br/>-->
                <?php if ($memberModifyInfo[0]->sex == 0) { ?>
                    <input type="radio" name="sex" value="남" checked="checked">男
                    <input type="radio" name="sex" value="여">女
                <?php } else { ?>
                    <input type="radio" name="sex" value="남">男
                    <input type="radio" name="sex" value="여" checked="checked">女
                <?php } ?>


                <p>Age Group</p>
                <select name="old">
                    <option><?= $memberModifyInfo[0]->old ?></option>
                    <option>10</option>
                    <option>20</option>
                    <option>30</option>
                    <option>40</option>
                    <option>50</option>
                </select>

                <p>Interests</p>
                <p style="margin: 0 0 10px">
                <select id="interest">
                    <option value="">関心事選択</option>
                    <?php
                    $i = 1;
                    foreach($interestInfo as $row){ ?>
                        <option><?= $row->iname ?></option>

                        <?php $i++; }?>
                </select>
                <button style="padding: 0.5em 0.9em 0.5em 0.9em" type="button" id="addItemBtn">関心事追加</button>
                </p>
                <span class='i' style="display:none"><?= $i ?></span>
                <div id="example">
                    <div class="item1">
                    </div>
                </div>
                <br/>

                <p>
                    <input type="submit" value="修正" name="submit_modify">
                    <input type="button" value="キャンセル" onclick="history.go(-1)">
                </p>
            </form>
            <br/>
            <p>'ことこと' をこれ以上利用しないなら <a style="text-decoration:underline; cursor: pointer;" onclick="memberLeave();">会員脱退ショートカット▶</a></p>
        </div>
    </article>
</div>
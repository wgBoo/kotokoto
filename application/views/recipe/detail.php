
<link rel="stylesheet" href="/public/assets/css/daejoon/nivo-slider.css" media="screen">
<link rel="stylesheet" href="/public/assets/css/daejoon/futurico-theme.css" media="screen">

<div style="height: 700px">

    <div id="wrapper" style="float: left;">

        <!-- Slider -->
        <div class="slider-wrapper futurico-theme">

            <div id="slider" class="nivoSlider">

                <img src="/public/assets/img/recipe/<?php echo $detail->rpicture; ?>" alt="">

                <img src="/public/assets/img/recipe/肉じゃがレシピ2.jpg" alt="">

                <img src="/public/assets/img/recipe/肉じゃがレシピ3.jpg" alt="">

                <img src="/public/assets/img/recipe/肉じゃがレシピ4.jpg" alt="">

            </div>
        </div>
    </div>

    <div style="width: 400px; height: 400px; float: left; margin: 40px;">
        <input type="hidden" id="temporarily" value="<?php echo $detail->rprice ?>">

        <div
            style=" border-bottom: 1px solid #e3e3e3; border-top: 1px solid #e3e3e3; padding-top: 15px; padding-bottom: 15px; margin-bottom: -1px; word-break: keep-all"
            align="center">
            <b style="font-size:25px; color:#494949; font-family: 'Malgun Gothic',돋움,sans-serif; letter-spacing: 10px;">
                <?php echo $detail->rname; ?>
            </b>
        </div>
        <div
            style="font:17px dotum; color: #666666; border-bottom: 1px solid #e3e3e3; margin: 10px; letter-spacing: 5px">
            <table border="1" cellpadding="0" cellspacing="0" style="line-height: 200%;">
                <tr>
                    <th>価格 :</th>
                    <td style="color: red; font-size: 20px; font-weight: 900"><span class="my_cb_result"
                                                                                    id="rprice"><?php echo $detail->rprice ?></span>円
                    </td>
                </tr>
                <tr>
                    <th>調理時間 :</th>
                    <td><?php echo $detail->rtime ?>分</td>
                </tr>
                <tr>
                    <th>数量 :</th>
                    <td><input type="number" id="stock" name="stock" min="1" max="100" value="1"></td>
                </tr>
                <form method="post" action="/Buy/address">
                    <tr>
                        <th>受ける日 :</th>
                        <td><input style="margin-top:10px;" type="date" name="owishday" required></td>
                    </tr>

                    <tr>

                        <input type="hidden" name="price" id="price" value="<?php echo $detail->rprice ?>">
                        <input type="hidden" name="rno" id="rno" value="<?php echo $detail->rno ?>">

                        <th>
                            <input style="margin-top: 15px;" type="submit" id="buybtn" value="購入">
                        <td>
                            <input style="margin-top: 15px;" type="button" id="cartbtn" value="買物かご">
                        </td>
                        </th>
                    </tr>

                </form>
            </table>
        </div>

    </div>
    <div id="crops">
        <table>
            <tr>
                <?php
                foreach ($crops as $crop) {
                    if ($crop->rmexclude == true) {
                        ?>
                        <td id="<?php echo "true" . $crop->cno ?>">
                            <input type="checkbox" checked="checked" disabled="true" name="box"
                                   id="<?php echo $crop->cno ?>" value="<?php echo $crop->cname ?>">
                            <?php echo $crop->cname . "(" . $crop->fname . ")";
                            ?>
                        </td>
                        <?php

                    }
                } ?>
            </tr>
            <tr>
                <?php
                foreach ($crops as $crop) {
                    if ($crop->rmexclude == false) { ?>
                        <td id="<?php echo "false" . $crop->cno ?>">
                            <input type="checkbox" name="box" checked="checked" id="<?php echo $crop->cno ?>"
                                   class="<?php echo $crop->mprice * $crop->rmmstock ?>"
                                   value="<?php echo $crop->cname ?>">
                            <?php echo $crop->cname . "(" . $crop->fname . ")";
                            ?>
                        </td>
                        <?php
                    }
                }
                ?>
            </tr>
        </table>
        <div align="center">
        <input type="button" value="生産地選択" onclick="farmcheck()">
        </div>
    </div>
    <div style="display: none" id="farms">
        <div id="morefarms">

            <div id="cropname">

            </div>
            <div id="farmname">

            </div>
        </div>
        <input type="button" value="選択完了" onclick="checkend()">
    </div>


    

    <script>
        $("input[name='box']").on('click', function () {
            var checkboxcheck = $(this).attr('checked'); //체크여부
            var money = $(this).attr('class'); // 재료가격
            if (money <= 50) {
                money = 50;
            } else {
                money = 100;
            }
            var inprice = document.getElementById("rprice").innerText; //현재가격
            var number = document.getElementById('stock').value; //수량
            if (checkboxcheck == 'checked') {
                var ptotal = money * number;
                var total1 = parseInt(inprice) + ptotal;
                $('.my_cb_result').text(total1);
            } else {
                var mtotal = money * number;
                var total2 = inprice - mtotal;
                var total2 = inprice - mtotal;
                $('.my_cb_result').text(total2);
            }
        });

        function farmcheck() {
            if ($("#crops").css("display") != "none") {
                jQuery("#crops").hide();
                jQuery("#farms").show();
                $("#morefarms").text('');
            }
            $("input[name='box']:checked").each(function () {
                var checkcrops = $(this).val();
                $.ajax({
                    url: '/Recipe/get_farms',
                    dataType: 'text',
                    type: 'post',
                    data: {
                        checkcrops: checkcrops
                    },
                    success: function (data) {
                        var farms = jQuery.parseJSON(data)['test'];

                        $("#morefarms").append(farms[0].cname, "\n");
                        for (var i = 0; i < farms.length; i++) {
                            if (i == 0) {
                                $("#morefarms").append("<input type='radio' checked='checked' class=" + farms[i].mprice + " id=" + farms[i].cno + " value=" + farms[i].fname + " name=" + farms[i].cname + ">", "<a href='#' id=" + farms[i].fname + " onclick='farminfor(this.id)'  data-toggle='modal' data-target='#myModal'>" + farms[i].fname + "</a>", "\n");
                            } else {
                                $("#morefarms").append("<input type='radio' id=" + farms[0].cno + " class=" + farms[i].mprice + " value=" + farms[i].fname + " name=" + farms[i].cname + ">", "<a href='#' id=" + farms[i].fname + " onclick='farminfor(this.id)' data-toggle='modal' data-target='#myModal'>" + farms[i].fname + "</a>", "\n");
                            }
                        }
                        $("#morefarms").append("<br>");
                    }
                });
            });
        }
        function farminfor(fname) {
            $.ajax({
                url: '/Recipe/get_farminfor',
                dataType: 'text',
                type: 'post',
                data: {
                    fname: fname
                },
                success: function (data) {
                    var farminfor = jQuery.parseJSON(data);
                    $('.modal-body-img').html("<img style='width: 200px; height: 200px' src=/public/assets/img/farm/" + farminfor[0].fpname + ">");
                    $('.modal-body-contents').html("&nbsp&nbsp" + farminfor[0].farmer + "<br><br>&nbsp&nbsp" + farminfor[0].fphone + "<br><br>&nbsp&nbsp" + farminfor[0].fname + "<br><br>&nbsp&nbsp" + farminfor[0].flocation);
                    $('.modal-body-intro').html("<br>" + farminfor[0].fintro);
                }
            });

        }

        function checkend() {
            if ($("farms").css("display") != "none") {
                jQuery("#farms").hide();
                jQuery("#crops").show()
            }
            $("input[type='radio']:checked").each(function () {
                var checkfarms = $(this).val(); //농장
                var cropsname = $(this).attr('name');//작물명
                var cropsnum = $(this).attr('id');//cno
                var cropsprice = $(this).attr('class');//가격

                var parent = document.getElementById(cropsnum).parentNode.id;
                if (parent == "true" + cropsnum) {
                    $("#" + parent + "").html("<input type='checkbox' checked=checked disabled=true name='box' id=" + cropsnum + " value=" + cropsname + " >" + cropsname + "(" + checkfarms + ")");
                } else {
                    $("#" + parent + "").html("<input type='checkbox' checked=checked name='box' id=" + cropsnum + " value=" + cropsname + " >" + cropsname + "(" + checkfarms + ")");
                }
            });

        }


    </script>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">生産地情報</h4>
                </div>
                <div class="modal-body" style="height: 450px;">

                    <div class="modal-body-img" style=" float: left">

                    </div>
                    <div class="modal-body-contents" style="float: left">

                    </div>
                    <div class="modal-body-intro" style="float: left">

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script>

    $('#stock').on('keyup mouseup', function () {
        var price = document.getElementById('temporarily').value;
        var number = parseInt($(this).val());//수량
        var total = price * number;

        $('.my_cb_result').text(parseInt(total));
        $('#price').val(total);
    });

</script>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://googledrive.com/host/0B-QKv6rUoIcGREtrRTljTlQ3OTg"></script>
<!-- ie10-viewport-bug-workaround.js -->
<script src="http://googledrive.com/host/0B-QKv6rUoIcGeHd6VV9JczlHUjg"></script><!-- holder.js -->

<script>

    $(document).ready(function () {
        var loginID = '<?= $login=isset($_SESSION['loginID']) ? $_SESSION['loginID']: null; ?>';
        $("#cartbtn").click(function () {
            if (!loginID) {
                alert('로그인 후 가능합니다.')
            } else {
                var mno = [];
                $("div#choiceexclude input[name='mno']").each(function (i) {
                    mno.push($(this).val());
                });
                $.ajax({
                    url: '/Buy/insert_shoppingbag',
                    dataType: 'text',
                    type: 'post',
                    data: {
                        'rno': $('#rno').val(),
                        'rprice': document.getElementById("rprice").innerText,
                        'sstock': $('#stock').val(),
                        'mno': mno
                    },
                    success: function (data) {
                        alert(data)
                    }
                })
            }
        })
    })
</script>
<script>
    $(document).ready(function () {
        var loginID = '<?= $login=isset($_SESSION['loginID']) ? $_SESSION['loginID']: null; ?>';
        $("#buybtn").click(function () {
            if (!loginID) {
                alert('로그인 후 가능합니다.')
            } else {

            }
        })
    })
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="/public/assets/js/daejoon/jquery.nivo.slider.pack.js"></script>
<script>
    $(window).load(function () {
        $('#slider').nivoSlider({
            effect: 'random',
            directionNavHide: false,
            pauseOnHover: true,
            captionOpacity: 1,
            prevText: '<',
            nextText: '>'
        });
    });
</script>



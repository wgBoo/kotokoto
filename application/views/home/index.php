<!-- Features -->
<!-- 반응형 -->
<style>
    body {
        padding: 0px;
        margin: 0px;
    }
</style>
<!--<script>
    $(function () {
        $("#da-slider img, .resizablebox").each(function () {
            var oImgWidth = $(this).width();
            var oImgHeight = $(this).height();
            $(this).css({
                'max-width': oImgWidth + 'px',
                'max-height': oImgHeight + 'px',
                'width': '100%',
                'height': '100%'
            });
        });
    });
</script>
-->

<script src="/public/assets/js/jquery.bxslider.js"></script>

<!-- bxSlider CSS file -->
<link href="/public/assets/css/bxslider/jquery.bxslider.css" rel="stylesheet" />

<script>
    $(document).ready(function () {
        var bodyWidth = document.body.clientWidth;
        if (bodyWidth < 400) {
            var divheight = document.getElementById('da-slider');
            divheight.style.height = 450 + "px";
            var divcount = $("ul.bxslider  > li").length;
            //alert(divcount);
            for (var i = 1; i <= divcount; i++) {
                var imgid = 'image'+i;

                var image = document.getElementById(imgid);
                image.src = '/public/assets/img/main/' + i + '-2.jpg';
            }
        }


        $('.bxslider').bxSlider({
            mode:'horizontal', //default : 'horizontal', options: 'horizontal', 'vertical', 'fade'
            speed:1000,         //default:500 이미지변환 속도
            auto: true,         //default:false 자동 시작
            captions: false,     // 이미지의 title 속성이 노출된다.
            autoControls: true //default:false 정지,시작 콘트롤 노출, css 수정이 필요
        });
    });
</script>

<div id="features-wrapper">
    <section id="features" class="container" style="width: 100%;">

        <div id="da-slider">
            <ul class="bxslider">
                <li><img id="image1" src="/public/assets/img/main/1-1.jpg" title="caption value pic1"/></li>
                <li><img id="image2" src="/public/assets/img/main/2-1.jpg" title="caption value pic2"/></li>
                <li><img id="image3" src="/public/assets/img/main/3-1.jpg" title="caption value pic3"/></li>
                <li><img id="image4" src="/public/assets/img/main/4-1.jpg" title="caption value pic4"/></li>
            </ul>
        </div>
    </section>
</div>






<!-- Banner -->
<div id="banner-wrapper">
    <div class="inner">
        <section id="banner" class="container" style="width: 100%">
            <header>
                <h2 style="color: #f56321">1０分ぶりに作る <strong style="color: #f56321">簡単な料理!!</strong></h2>
            </header>
            <div class="row">
                <?php foreach ($mainRecipe as $recipe) { ?>
                    <div class="3u 12u(mobile)">
                        <!-- Feature -->

                            <a href="/Recipe/detail/<?php echo $recipe->rno; ?>" class="image featured"><img
                                    src="/public/assets/img/recipe/<?php echo $recipe->rpicture ?>" alt=""/></a>
                            <header>
                                <h3><?php echo $recipe->rname ?></h3>
                            </header>
                            <p><strong><?php echo $recipe->rname ?></strong>
                                <?php
                                $count = 0; ?>には
                                <?php foreach ($mainCrops as $crop) {
                                    if ($recipe->rname == $crop->rname)
                                        if ($crop->rmexclude == true) {
                                            echo $crop->cname . " ";
                                            $count++;
                                        } else
                                            $count++;
                                } ?> など
                                <?php echo $count; ?>つの材料が使われており,
                                <?php foreach ($mainInterest as $interest) {
                                    if ($recipe->rname == $interest->rname) {
                                        echo $interest->iname . "&nbsp";
                                    }
                                }
                                echo "に良い効果があります。"; ?>
                            </p>

                    </div>
                    <?php
                } ?>
            </div>
            <ul class="actions">
                <li><a href="/Recipe/all/0" class="button icon fa-file">Tell Me More</a></li>
            </ul>
        </section>
    </div>
</div>

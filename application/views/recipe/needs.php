 <?php

    if ($needsRecipe!=null) { ?>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/daejoon/jstyle.css"/>
    <link href='http://fonts.googleapis.com/css?family=Dosis:200,400,700' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/public/assets/js/daejoon/modernizr.custom.79639.js"></script>

    <section id="needs">
        <!-- Codrops top bar -->
    <section id="ps-container" class="ps-container">
        <div class="ps-header">
           <h1>Needs</h1>
        </div><!-- /ps-header -->
        <div class="ps-contentwrapper">

            <?php
            foreach ($needsRecipe as $recipe) { ?>
                <div class="ps-content">
                    <h2><?php echo $recipe->rname; ?></h2>
                    <span class="ps-price" style="margin: 0; padding: 0;"><?php echo $recipe->rprice ?><b style="font-size: 35px; font-weight: 800; color: #fff;"><?php echo $recipe->iname ?></b></span>
                    <p>

                        <?php echo $recipe->rname;
                        $count = 0;?>には
                        <?php foreach($needsCrops as $crop){
                           if($recipe->rname == $crop-> rname)
                            if($crop->rmexclude == true){
                                echo $crop->cname." ";
                                $count++;  }
                            else
                                $count++;
                        } ?> など
<?php echo $count; ?>つの材料で料理しました。<?php echo $recipe->icontent ?>
                    </p>
                    <a href="/Recipe/detail/<?php echo $recipe->rno; ?>">Buy this item </a>
                </div>
                <?php
            } ?>

        </div><!-- /ps-contentwrapper -->

        <div class="ps-slidewrapper">

            <div class="ps-slides">
                <?php foreach ($needsRecipe as $recipe) { ?>
                    <div style="background-image:url(/public/assets/img/recipe/<?php echo $recipe->rpicture ?>);"></div>
                <?php } ?>
            </div>

            <nav>
                <a href="#" class="ps-prev"></a>
                <a href="#" class="ps-next"></a>
            </nav>

        </div><!-- /ps-slidewrapper -->

    </section><!-- /ps-container -->
        <!-- jQuery if needed -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="/public/assets/js/daejoon/slider.js"></script>
        <script type="text/javascript">
            $(function () {

                Slider.init();

            });
        </script>
    </section>
        <?php
    } else { ?>
        <link rel="stylesheet" type="text/css" href="/public/assets/css/daejoon/jnormalize.css" />
        <link rel="stylesheet" type="text/css" href="/public/assets/css/daejoon/demo.css" />
        <link rel="stylesheet" type="text/css" href="/public/assets/css/daejoon/component.css" />
        <script src="/public/assets/js/daejoon/modernizr.custom.js"></script>

        <div class="container">
            <!-- Top Navigation -->
            <p align="center">상품 추천을 받을려면 로그인을 하셔야 합니다.</p>
            <section class="grid-wrap">
                <ul class="grid swipe-down" id="grid">
                    <li class="title-box">
                        <h2 align="center">All</h2>
                    </li>
                    <?php foreach($allRecipe as $recipe){ ?>
                        <li><a href="/Recipe/detail/<?php echo $recipe->rno; ?>"><img src="/public/assets/img/recipe/<?php echo $recipe->rpicture ?>"><h3><?php echo $recipe->rname ?><br><?php echo $recipe->rprice ?></h3></a></li>
                        <?php
                    } ?>
                </ul>
            </section>

        </div><!-- /container -->
        <script src="/public/assets/js/daejoon/masonry.pkgd.min.js"></script>
        <script src="/public/assets/js/daejoon/imagesloaded.pkgd.min.js"></script>
        <script src="/public/assets/js/daejoon/classie.js"></script>
        <script src="/public/assets/js/daejoon/colorfinder-1.1.js"></script>
        <script src="/public/assets/js/daejoon/gridScrollFx.js"></script>
        <script>
            new GridScrollFx( document.getElementById( 'grid' ), {
                viewportFactor : 0.4
            } );
        </script>

        <?php
    }
    ?>

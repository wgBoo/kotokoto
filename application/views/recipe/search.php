<link rel="stylesheet" type="text/css" href="/public/assets/css/daejoon/jnormalize.css" />
<link rel="stylesheet" type="text/css" href="/public/assets/css/daejoon/demo.css" />
<link rel="stylesheet" type="text/css" href="/public/assets/css/daejoon/component.css" />
<script src="/public/assets/js/daejoon/modernizr.custom.js"></script>

<div class="container">
    <!-- Top Navigation -->
    <section class="grid-wrap">
        <ul class="grid swipe-down" id="grid">
            <li class="title-box">
                <h2 align="center">Search</h2>
            </li>
            <?php foreach($searchRecipe as $recipe){ ?>
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

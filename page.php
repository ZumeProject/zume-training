<?php get_header(); ?>

<div id="content">

    <div id="inner-content grid-x grid-padding-x">

        <div id="simple-main" class="cell padding-top-1" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>

            <?php endwhile;
            endif; ?>

        </div>

    </div>

</div>

<?php get_footer(); ?>

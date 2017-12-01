<?php
/*
Template Name: Zúme Dashboard
*/

get_header();

?>

<div id="content">

    <div id="inner-content" class="row">

        <main id="main" class="large-12 medium-12 columns" role="main">

            <?php echo 'Current User ID is: ' . get_current_user_id(); ?>

        </main> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>

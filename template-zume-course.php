<?php
/*
Template Name: Zúme Training
*/

get_header();

?>

	<div id="content">

		<div id="inner-content" class="row">

			<main id="main" class="large-12 medium-12 columns" role="main">



					<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/WebPage">

						<header class="article-header">

						</header> <!-- end article header -->

						<section class="entry-content" itemprop="articleBody">

							<?php
                            /**
                             * Zúme Course Content Loader
                             *
                             * @param 'id' in the url the id and session number is used to call the correct session.
                             */
                            Zume_Course::instance()->zume_pre_content_load();



                            ?>

						</section> <!-- end article section -->

						<footer class="article-footer">

						</footer> <!-- end article footer -->



					</article> <!-- end article -->



			</main> <!-- end #main -->

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>

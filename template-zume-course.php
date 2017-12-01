<?php
/*
Template Name: Zúme Training
*/

get_header();

?>

	<div id="content">

		<div id="inner-content" class="row">

			<div id="main" class="large-12 medium-12 columns" role="main">

				<?php
				/**
				 * Load Zume Course Content
				 */


				Zume_Course::instance()->zume_pre_content_load();



				?>

			</div> <!-- end #main -->

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>

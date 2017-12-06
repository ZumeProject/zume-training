<div id="post-not-found" class="hentry">

	<?php if ( is_search() ) : ?>

        <header class="article-header">
            <h1><?php esc_html_e( 'Sorry, No Results.', 'zume' );?></h1>
        </header>

        <section class="entry-content">
            <p><?php esc_html_e( 'Try your search again.', 'zume' );?></p>
        </section>

        <section class="search">
            <p><?php get_search_form(); ?></p>
        </section> <!-- end search section -->

        <footer class="article-footer">
            <p><?php esc_html_e( 'This is the error message in the parts/content-missing.php template.', 'zume' ); ?></p>
        </footer>

    <?php else : ?>

        <header class="article-header">
            <h1><?php esc_html_e( 'Oops, Post Not Found!', 'zume' ); ?></h1>
        </header>

        <section class="entry-content">
            <p><?php esc_html_e( 'Uh Oh. Something is missing. Try double checking things.', 'zume' ); ?></p>
        </section>

        <section class="search">
            <p><?php get_search_form(); ?></p>
        </section> <!-- end search section -->

        <footer class="article-footer">
          <p><?php esc_html_e( 'This is the error message in the parts/content-missing.php template.', 'zume' ); ?></p>
        </footer>

    <?php endif; ?>

</div>

<?php get_header(); ?>

    <div id="content">

        <div id="inner-content" class="row">

            <main id="main" class="large-8 medium-8 columns" role="main">

                <article id="content-not-found">

                    <header class="article-header">
                        <h1><?php esc_html_e( 'Epic 404 - Article Not Found', 'zume' ); ?></h1>
                    </header> <!-- end article header -->

                    <section class="entry-content">
                        <p><?php esc_html_e( 'The article you were looking for was not found, but maybe try looking again!', 'zume' ); ?></p>
                    </section> <!-- end article section -->

                    <section class="search">
                        <p></p>
                    </section> <!-- end search section -->

                </article> <!-- end article -->

            </main> <!-- end #main -->

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php get_footer(); ?>

<?php
/*
Template Name: Zúme Overview
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
                         * Zúme Overview Content Loader
                         *
                         * @param 'id' in the url the id and session number is used to call the correct session.
                         */

                        $user_id = get_current_user_id();
                        $meta_key = 'zume_active_group';

                        $group_id = '';
                        $next_session = '';
                        $session = '';
                        Zume_Overview::instance()->zume_sessions_overview($group_id, $next_session, $session);



                        ?>

                    </section> <!-- end article section -->

                    <footer class="article-footer">

                    </footer> <!-- end article footer -->



                </article> <!-- end article -->



            </main> <!-- end #main -->

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php get_footer(); ?>

<?php extract( $wp_query->query_vars ); // gets the variables set in the template ?>

<?php /** Logged in */ if ( is_user_logged_in() ) : ?>

<div class="training margin-top-3 margin-bottom-3">
    <div class="grid-x grid-margin-x grid-margin-y landing-part">
        <div class="small-12 small-centered cell center landing">
            <h2><?php echo esc_html__("Great job! Here's your progress with this concept", 'zume' ) ?>:</h2>
        </div>
        <div class="cell">
            <div class="grid-x">
                <div class="cell small-2"></div>
                <div class="cell small-2 center">
                    <div class="stat-landing-title"><?php echo esc_html__("Heard", 'zume' ) ?></div>
                    <i class="p-icon-landing complete" id="<?php echo esc_attr( $session_number ) ?>h"></i>
                </div>
                <div class="cell small-2 center">
                    <div class="stat-landing-title"><?php echo esc_html__("Obeyed", 'zume' ) ?></div>
                    <i class="p-icon-landing" id="<?php echo esc_attr( $session_number ) ?>o"></i>
                </div>
                <div class="cell small-2 center">
                    <div class="stat-landing-title"><?php echo esc_html__("Shared", 'zume' ) ?></div>
                    <i class="p-icon-landing" id="<?php echo esc_attr( $session_number ) ?>s"></i>
                </div>
                <div class="cell small-2 center">
                    <div class="stat-landing-title"><?php echo esc_html__("Trained", 'zume' ) ?></div>
                    <i class="p-icon-landing" id="<?php echo esc_attr( $session_number ) ?>t"></i>
                </div>
                <div class="cell small-2"></div>
            </div>
        </div>
        <div class="cell center">
            <p><a href="<?php echo esc_url( zume_training_url() ) ?>" class="button large"><?php echo esc_html__("Return to Training", 'zume' ) ?></a> <a href="" class="button large">Start Session <?php echo esc_attr( $session_number ) ?></a></p>
        </div>
        <script>
            jQuery(document).ready(function(){
                window.API.update_progress( '<?php echo esc_attr( $session_number ) ?>h', 'on' )
            })
        </script>
    </div>
</div>
<?php endif; ?>





<?php /** Not logged in */ if ( ! is_user_logged_in() ) : ?>

<div class="training margin-top-3 margin-bottom-3">
    <div class="grid-x grid-margin-x grid-margin-y landing-part">
        <div class="small-12 small-centered cell center landing">
            <?php echo esc_html__("You've heard the concept. We challenge you to live it, share it, and train others!", 'zume' ) ?><br>
            <a href="<?php echo zume_login_url() ?>" class="button large">Login</a> <a href="<?php echo zume_register_url() ?>" class="button large">Register</a>

        </div>
    </div>
</div>

<?php endif; ?>

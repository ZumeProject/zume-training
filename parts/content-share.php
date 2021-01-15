<?php
// @codingStandardsIgnoreLine
$vars = $wp_query->query_vars;
$session_number = $vars['session_number'];
$tool_number = $vars['tool_number'];
?>

<?php /** Logged in */ if ( is_user_logged_in() ) : ?>

<div class="training margin-top-3 margin-bottom-3">
    <div class="grid-x grid-margin-x grid-padding-y padding-1 landing-part">
        <div class="small-12 small-centered cell center landing">
            <h2><?php echo esc_html__( "Great job! Here's your progress with this concept", 'zume' ) ?>:</h2>
        </div>
        <div class="cell">
            <div class="grid-x landing-host-list">
                <div class="cell auto"></div>
                <div class="cell small-1 center">
                    <div class="stat-landing-title"><?php echo esc_html__( "Heard", 'zume' ) ?></div>
                    <i class="p-icon-landing complete" id="<?php echo esc_attr( $tool_number ) ?>h"></i>
                </div>
                <div class="cell small-1 center">
                    <div class="stat-landing-title"><?php echo esc_html__( "Obeyed", 'zume' ) ?></div>
                    <i class="p-icon-landing" id="<?php echo esc_attr( $tool_number ) ?>o"></i>
                </div>
                <div class="cell small-1 center">
                    <div class="stat-landing-title"><?php echo esc_html__( "Shared", 'zume' ) ?></div>
                    <i class="p-icon-landing" id="<?php echo esc_attr( $tool_number ) ?>s"></i>
                </div>
                <div class="cell small-1 center">
                    <div class="stat-landing-title"><?php echo esc_html__( "Trained", 'zume' ) ?></div>
                    <i class="p-icon-landing" id="<?php echo esc_attr( $tool_number ) ?>t"></i>
                </div>
                <div class="cell auto"></div>
            </div>
        </div>
        <div class="cell center">
            <p>
                <a href="<?php echo esc_url( zume_training_url() ) ?>#panel1" class="button primary-button-hollow large"><?php echo esc_html__( "Course Overview", 'zume' ) ?></a>
                <a href="<?php echo esc_url( zume_training_url() ) ?>#panel2" class="button primary-button-hollow large"><?php echo esc_html__( "Groups", 'zume' ) ?></a>
                <a href="<?php echo esc_url( zume_training_url() ) ?>#panel3" class="button primary-button-hollow large"><?php echo esc_html__( "Checklist", 'zume' ) ?></a>
                <a onclick="open_session( <?php echo esc_attr( $session_number ) ?> )" class="button primary-button-hollow large"><?php echo esc_html__( "Start Session", 'zume' ) ?></a>
            </p>
        </div>
        <script>
            jQuery(document).ready(function(){
                if ( typeof window.API !== 'undefined' ) {
                    window.API.update_progress('<?php echo esc_attr( $tool_number ) ?>h', 'on')
                    load_progress()
                }
            })
        </script>

        <div class="cell"><hr></div>
        <div class="cell center">
            <p><?php echo esc_html__( "Zúme Training is freely offered as part of larger Zúme Vision.", 'zume' ) ?> </p>
            <p><a class="button large primary-button-hollow" href="https://zume.vision"><?php echo esc_html__( "Learn more about the Zúme.Vision", 'zume' ) ?></a></p>
        </div>
    </div>
</div>
<?php endif; ?>





<?php /** Not logged in */ if ( ! is_user_logged_in() ) : ?>

<div class="training margin-top-3 margin-bottom-3">
    <div class="grid-x padding-2 landing-part">

        <div class="cell center"><h2><?php echo esc_html__( "You're missing out.", 'zume' ) ?> <?php echo esc_html__( "Register Now!", 'zume' ) ?></h2></div>
        <div class="cell list-reasons">
            <ul>
                <li><?php echo esc_html__( "track your personal training progress", 'zume' ) ?></li>
                <li><?php echo esc_html__( "access group planning tools", 'zume' ) ?></li>
                <li><?php echo esc_html__( "connect with a coach", 'zume' ) ?></li>
                <li><?php echo esc_html__( "add your effort to the global vision!", 'zume' ) ?></li>
            </ul>
        </div>
        <div class="cell center">
            <a href="<?php echo esc_url( zume_register_url() ) ?>" class="button large secondary-button" style="padding-right:2em;padding-left:2em;"><?php echo esc_html__( "Register for Free", 'zume' ) ?></a><br>
            <a href="<?php echo esc_url( zume_login_url() ) ?>" class="button clear"><?php echo esc_html__( "Login", 'zume' ) ?></a>
        </div>
        <div class="cell"><hr></div>
        <div class="cell center">
            <p style="max-width:500px; margin:1em auto;"><?php echo esc_html__( "Zúme uses an online training platform to equip participants in basic disciple-making and simple church planting multiplication principles, processes, and practices.", 'zume' ) ?></p>
            <p><a class="button primary-button-hollow large" href="<?php echo esc_url( zume_training_url() ) ?>"><?php echo esc_html__( "See Entire Training", 'zume' ) ?></a></p>
        </div>
        <div class="cell"><hr></div>
        <div class="cell center">
            <p><?php echo esc_html__( "Zúme Training is freely offered as part of larger Zúme Vision.", 'zume' ) ?> </p>
            <p><a class="button large primary-button-hollow" href="https://zume.vision"><?php echo esc_html__( "Learn more about the Zúme.Vision", 'zume' ) ?></a></p>
        </div>
    </div>
</div>

<?php endif; ?>

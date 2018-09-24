<?php
/*
Template Name: Zume Login
*/
?>

<?php get_header(); ?>

<div id="content">
    <div id="login">
        <br>
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
            <div class="cell medium-3 large-4"></div>
            <div class="cell callout medium-6 large-4">
                <div class="grid-x grid-padding-x grid-padding-y">
                    <div class="cell center"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" /></div>
                    <div class="cell">
                        <div class="wp_login_form">
                            <?php
                            $args = array(
                                'redirect' => site_url(),
                                'id_username' => 'user',
                                'id_password' => 'pass',
                                'value_remember' => true,
                            );
                            wp_login_form( $args );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cell medium-3 large-4"></div>
        </div>
        <div class="grid-x grid-padding-x">
            <div class="cell medium-3 large-4"></div>
            <div class="cell medium-6 large-4">
                <p id="nav">
                    <?php if ( ! isset( $_GET['checkemail'] ) || ! in_array( wp_unslash( $_GET['checkemail'] ), array( 'confirm', 'newpass' ) ) ) :
                        if ( get_option( 'users_can_register' ) ) :
                            echo '<a href="' . esc_url( zume_get_posts_translation_url( 'Register' ) ) . '">'. esc_html__( 'Register' ) .'</a>';
                        endif;
                        ?>
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?' ); ?></a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="cell medium-3 large-4"></div>
        </div>
    </div>
</div>
<style>
    body.login {
        background: none;
    }
    #wp-submit {
        background: #fefefe;
        border: 0;
        color: #323A68;
        font-size: medium;
        cursor: pointer;
        outline: #323A68 solid 1px;
        padding: 0.85em 1em;
        text-align: center;
        text-decoration: none;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        margin: 2px;
        height: inherit;
        text-shadow: none;
        float:right;
    }
    #wp-submit:hover {
         background: #323A68;
         border: 0;
         color: #fefefe;
         font-size: medium;
         cursor: pointer;
         outline: #323A68 solid 1px;
         padding: 0.85em 1em;
         text-align: center;
         text-decoration: none;
         -webkit-border-radius: 0;
         -moz-border-radius: 0;
         border-radius: 0;
         margin: 2px;
         height:inherit;
        float:right;
     }
    .login h1 a {
        background: url(<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>) no-repeat top center;
        width: 326px;
        height: 67px;
        text-indent: -9999px;
        overflow: hidden;
        padding-bottom: 15px;
        display: block;
    }
    #nav a {
        background: #fefefe;
        border: 0;
        color: #323A68;
        font-size: medium;
        cursor: pointer;
        outline: #323A68 solid 1px;
        padding: 1em;
        text-align: center;
        text-decoration: none;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        margin: 2px;
    }
    #nav a:hover {
        background: #323A68;
        border: 0;
        color: #fefefe;
        font-size: medium;
        cursor: pointer;
        outline: #323A68 solid 1px;
        padding: 5px;
        text-align: center;
        text-decoration: none;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        margin: 2px;
    }
    @media only screen and (min-width: 640px) {
        #nav a {
            padding: 1em !important;
        }
        #nav a:hover {
            padding: 1em !important;
        }
    }
</style>

<?php get_footer(); ?>
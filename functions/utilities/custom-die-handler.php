<?php

add_filter( 'wp_die_handler', 'zume_get_die_handler' );

function zume_get_die_handler() {
    return 'zume_die_handler';
}

/*
 * @param string|WP_Error $message Error message or WP_Error object.
 * @param string          $title   Optional. Error title. Default empty.
 * @param string|array    $args    Optional. Arguments to control behavior. Default empty array.
 */
function zume_die_handler( $message, $title = '', $args = array() ) {
    $defaults = array( 'response' => 500 );
    $r = wp_parse_args( $args, $defaults );

    $have_gettext = function_exists( '__' );

    if ( function_exists( 'is_wp_error' ) && is_wp_error( $message ) ) {
        if ( empty( $title ) ) {
            $error_data = $message->get_error_data();
            if ( is_array( $error_data ) && isset( $error_data['title'] ) ) {
                $title = $error_data['title'];
            }
        }
        $errors = $message->get_error_messages();
        switch ( count( $errors ) ) {
            case 0 :
                $message = '';
            break;
            case 1 :
                $message = "<p>{$errors[0]}</p>";
            break;
            default:
                $message = "<ul>\n\t\t<li>" . join( "</li>\n\t\t<li>", $errors ) . "</li>\n\t</ul>";
            break;
        }
    } elseif ( is_string( $message ) ) {
        $message = "<p>$message</p>";
    }

    if ( isset( $r['back_link'] ) && $r['back_link'] ) {
        $back_text = $have_gettext ? __( '&laquo; Back' ) : '&laquo; Back';
        $message .= "\n<p><a href='javascript:history.back()'>$back_text</a></p>";
    }

    if ( ! did_action( 'admin_head' ) ) :
        if ( !headers_sent() ) {
            status_header( $r['response'] );
            nocache_headers();
            header( 'Content-Type: text/html; charset=utf-8' );
        }

        if ( empty( $title ) ) {
            $title = $have_gettext ? __( 'WordPress &rsaquo; Error' ) : 'WordPress &rsaquo; Error';
        }

        $text_direction = 'ltr';
        if ( isset( $r['text_direction'] ) && 'rtl' == $r['text_direction'] ) {
            $text_direction = 'rtl';
        } elseif ( function_exists( 'is_rtl' ) && is_rtl() ) {
            $text_direction = 'rtl';
        }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ( function_exists( 'language_attributes' ) && function_exists( 'is_rtl' ) ) { language_attributes();
} else { echo "dir='" . esc_attr( $text_direction ) . "'";
} ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width">
    <?php
    if ( function_exists( 'wp_no_robots' ) ) {
        wp_no_robots();
    }
    ?>
    <?php /* @codingStandardsIgnoreLine */ ?>
    <title><?php echo esc_attr( $title ) ?></title>
    <style type="text/css">
        html {
            background: #f1f1f1;
        }
        body {
            background: #fff;
            color: #444;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            margin: 2em auto;
            padding: 1em 2em;
            max-width: 700px;
            -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.13);
            box-shadow: 0 1px 3px rgba(0,0,0,0.13);
        }
        h1 {
            border-bottom: 1px solid #dadada;
            clear: both;
            color: #666;
            font-size: 24px;
            margin: 30px 0 0 0;
            padding: 0;
            padding-bottom: 7px;
        }
        #error-page {
            margin-top: 50px;
        }
        #error-page p {
            font-size: 14px;
            line-height: 1.5;
            margin: 25px 0 20px;
        }
        #error-page code {
            font-family: Consolas, Monaco, monospace;
        }
        ul li {
            margin-bottom: 10px;
            font-size: 14px ;
        }
        a {
            color: #0073aa;
        }
        a:hover,
        a:active {
            color: #00a0d2;
        }
        a:focus {
            color: #124964;
            -webkit-box-shadow:
                0 0 0 1px #5b9dd9,
                0 0 2px 1px rgba(30, 140, 190, .8);
            box-shadow:
                0 0 0 1px #5b9dd9,
                0 0 2px 1px rgba(30, 140, 190, .8);
            outline: none;
        }
        .button {
            background: #f7f7f7;
            border: 1px solid #ccc;
            color: #555;
            display: inline-block;
            text-decoration: none;
            font-size: 13px;
            line-height: 26px;
            height: 28px;
            margin: 0;
            padding: 0 10px 1px;
            cursor: pointer;
            -webkit-border-radius: 3px;
            -webkit-appearance: none;
            border-radius: 3px;
            white-space: nowrap;
            -webkit-box-sizing: border-box;
            -moz-box-sizing:    border-box;
            box-sizing:         border-box;

            -webkit-box-shadow: 0 1px 0 #ccc;
            box-shadow: 0 1px 0 #ccc;
             vertical-align: top;
        }

        .button.button-large {
            height: 30px;
            line-height: 28px;
            padding: 0 12px 2px;
        }

        .button:hover,
        .button:focus {
            background: #fafafa;
            border-color: #999;
            color: #23282d;
        }

        .button:focus  {
            border-color: #5b9dd9;
            -webkit-box-shadow: 0 0 3px rgba( 0, 115, 170, .8 );
            box-shadow: 0 0 3px rgba( 0, 115, 170, .8 );
            outline: none;
        }

        .button:active {
            background: #eee;
            border-color: #999;
             -webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
             box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
             -webkit-transform: translateY(1px);
             -ms-transform: translateY(1px);
             transform: translateY(1px);
        }

        <?php
        if ( 'rtl' == $text_direction ) {
            echo 'body { font-family: Tahoma, Arial; }';
        }
        ?>
    </style>
</head>
<body id="error-page">
<?php endif; // ! did_action( 'admin_head' ) ?>
    <?php /* @codingStandardsIgnoreLine */ ?>
    <?php echo esc_attr( $message ); ?>
    <div><p>
        <?php /* @codingStandardsIgnoreLine */ ?>
        You can contact <a href="mailto:<?php echo esc_attr( antispambot( "info@zumeproject.com" ) ); ?>"><?php echo esc_attr( antispambot( "info@zumeproject.com" ) ); ?></a>
        or continue to the <a href="<?php echo esc_attr( get_site_url() ) ?>">home page</a>.
    </p></div>
</body>
</html>
<?php
    die();
}

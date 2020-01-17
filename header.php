<?php //zume_force_login(); // requires no spaces above or else it will throw a headers already send error. ?>

<!doctype html>

  <html class="no-js"  <?php language_attributes(); ?>>

    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-MSGWKV5');</script>
        <!-- End Google Tag Manager -->
        <meta charset="utf-8">

        <!-- Force IE to use the latest rendering engine available -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta class="foundation-mq">

        <!-- If Site Icon isn't set in customizer -->
        <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
            <!-- Icons & Favicons -->
            <link rel="icon" href="<?php echo esc_attr( get_theme_file_uri( 'favicon.png' ) ); ?>">
            <link href="<?php echo esc_attr( get_theme_file_uri( 'assets/images/apple-icon-touch.png' ) ); ?>" rel="apple-touch-icon" />
            <!--[if IE]>
                <link rel="shortcut icon" href="<?php echo esc_attr( get_theme_file_uri( 'favicon.ico' ) ); ?>">
            <![endif]-->
            <meta name="msapplication-TileColor" content="#f01d4f">
            <meta name="msapplication-TileImage" content="<?php echo esc_attr( get_theme_file_uri( 'assets/images/win8-tile-icon.png' ) ); ?>">
            <meta name="theme-color" content="#121212">
        <?php } ?>

        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <?php wp_head(); ?>

        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1552465945075453');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                         src="https://www.facebook.com/tr?id=1552465945075453&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Facebook Pixel Code -->

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <?php // @codingStandardsIgnoreStart ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-102207784-1"></script>
        <?php // @codingStandardsIgnoreEnd ?>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-102207784-1');
        </script>

    </head>

    <!-- Uncomment this line if using the Off-Canvas Menu -->

    <body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSGWKV5"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

        <div class="off-canvas-wrapper">

            <?php get_template_part( 'parts/content', 'offcanvas' ); ?>

            <div class="off-canvas-content" data-off-canvas-content>

                <header class="header" role="banner">

                     <!-- This navs will be applied to the topbar, above all content
                          To see additional nav styles, visit the /parts directory -->
                        <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>

                </header> <!-- end .header -->

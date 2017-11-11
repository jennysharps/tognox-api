<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title><?php wp_title(''); ?></title>

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- icons & favicons (for more: http://themble.com/support/adding-icons-favicons/) -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico?v=2">

  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- drop Google Analytics Here -->
		<!-- end analytics -->

	</head>

	<body <?php body_class(); ?>>

        <?php
            $theme_options = get_option('theme_options');
            $ga_id = $theme_options['ga_id'];
        ?>

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', '<?php echo $ga_id; ?>');
          ga('send', 'pageview');
        </script>

                <header class="header" role="banner">

                        <div id="inner-header" class="wrap clearfix">

                                <div id="site-info">
                                        <a class="site-info-logo" href="<?php echo site_url(); ?>">
                                            <img class="site-logo" src="<?php echo get_template_directory_uri(); ?>/library/images/gaussian.png" width="84px;"/>
                                        </a>
                                        <div class="site-info-text">
                                                <a href="<?php echo site_url(); ?>"><h1 class="site-title"><?php bloginfo('name'); ?></h1></a>
                                                <p class="site-description"><?php bloginfo('description'); ?></p>
                                        </div>
                                </div>

                                <?php
                                $defaults = array(
                                        'theme_location'  => 'social_buttons_header',
                                        'container'       => 'div',
                                        'menu_class'      => 'social-menu',
                                        'echo'            => true,
                                        'fallback_cb'     => '',
                                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                        'depth'           => 1,
                                        'walker'          => ''
                                );

                                wp_nav_menu( $defaults );
                                ?>
                                <a class="toggle-menu-mobile toggle-menu-open"><span class="icon">|||</span></a>
                                <nav role="navigation">
                                        <?php bones_main_nav(); ?>
                                    <div class="toggle-menu-mobile toggle-menu-close"><span class="icon">&#9650;</span></div>
                                </nav>

                        </div> <!-- end #inner-header -->

                </header> <!-- end header -->

                <main>
                        <div class="wrap clearfix">
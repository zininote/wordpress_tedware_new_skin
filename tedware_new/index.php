<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
        <meta name="google-site-verification" content="VSLqZ4jMVCNL1v0UxrxMMF2fsgSfZyON7gDiwfTSmKQ" />
        <meta name="naver-site-verification" content="c77f7bb9521f009e415eb40a774953aeebbd2fe8"/>
        <meta property="og:title" content="<?php bloginfo('name'); ?>"/>
        <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>"/>
        <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/profile.png"/>
        <meta property="og:description" content="<?php bloginfo('description'); ?>"/>
        <title><?php wp_title(); ?></title>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"/>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/default.css"/>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style.css"/>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/editor-style.css"/>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        This HP is closed...
    </body>
</html>
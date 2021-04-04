<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body id="bg-post" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="header-light">
  <div class="container">
    <div class="header-wrapper">
        
      <?php
        // оригинальная структура для проверки и ссылки только на лого (без соседнего текста)
        /* if( has_custom_logo() ){
          echo '<div class="logo">' . get_custom_logo() .
          '<span class="logo-name">' . get_bloginfo('name') . '</span></div>';
        } else {
          echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
        } */

        // добаление ссылки для текста около ЛОГО - с проверкой (главная или нет)
        if(is_front_page()) :

          if( has_custom_logo() ){
            echo '<div class="logo">' . get_custom_logo() .
            '<span class="logo-name">' . get_bloginfo('name') . '</span></div>';
          } else {
            echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
          }

        else :

          if( has_custom_logo() ){
            echo '<div class="logo">' . get_custom_logo() .
            '<a href="' . get_bloginfo('url') . '"><span class="logo-name">' . get_bloginfo('name') . '</span></a></div>';
          } else {
            echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
          }

        endif;

        wp_nav_menu( [
          'theme_location'  => 'header_menu',
          'container'       => 'nav',
          'container_class' => 'header-nav',
          'menu_class'      => 'header-menu',
          'echo'            => true,
        ] );
      ?>
      <?php echo get_search_form(); ?>

      <a href="#" class="header-menu-toggle">
      <span></span>
      <span></span>
      <span></span>
      </a>
    </div>
  </div>
</header>
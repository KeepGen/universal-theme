<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <!-- выводим шапку поста -->
   <header class="entry-header <?php echo get_post_type(); ?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
      <?php
         if( has_post_thumbnail() ) {
            echo get_the_post_thumbnail_url();
         }
         else {
            echo get_template_directory_uri() .'/assets/images/img-default.png';
         } ?>)">
         
		<div class="container">

         <div class="post-header-wrapper">
            <div class="post-header-nav">
               <?php
                  foreach (get_the_category() as $category ) {
                     printf(
                        '<a href="%s" class="category-link %s">%s</a>',
                        esc_url ( get_category_link($category) ),
                        esc_html ( $category -> slug ),
                        esc_html ( $category -> name ),
                     );
                  }
               ?>

               <!-- Ссылка на главную-->
               <a class="home-link" href="<?php echo get_home_url() ?>">
                  <svg width="18" height="17" fill="#BCBFC2" class="icon comments-icon">
                     <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#home"></use>
                  </svg>
                  На главную
               </a>
               
               <?php
                  // выводим ссылки на предыдущий и следующие посты
                  the_post_navigation(
                     array(
                        'prev_text' => '<span class="post-nav-prev">
                           <svg width="15" height="7" fill="#000000" class="icon prev-icon">
                              <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#left-arrow"></use>
                           </svg>
                        ' . esc_html__( 'Назад', 'universal-theme' ) . '</span>' ,
                        'next_text' => '<span class="post-nav-next">
                        ' . esc_html__( 'Вперед', 'universal-theme' ) . '
                           <svg width="15" height="7" fill="#000000" class="icon next-icon">
                              <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#right-arrow"></use>
                           </svg>
                        </span>' ,
                     )
                  );
               ?>
            </div>
            <!-- /.post-header-nav -->

            <div class="post-header-title-wrapper">
               <?php
                  // проверяем, точно ли мы на странице поста
                  if ( is_singular() ) :
                     the_title( '<h1 class="post-header-title">', '</h1>' );
                  else :
                     the_title( '<h2 class="post-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                  endif;
               ?>
               <button class="bookmark">
                  <svg width="21" height="27" fill="#BCBFC2" class="icon bookmark-icon bookmark-icon-header">
                     <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#bookmark"></use>
                  </svg>
               </button>
            </div>

            <?php the_excerpt(); ?>

            <div class="post-header-info">
               <div class="post-header-date">
                  <svg width="15" height="15" fill="#BCBFC2" class="icon time-icon">
                     <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#time"></use>
                  </svg>
                  <?php the_time('j F, G:i'); ?>
               </div>

               <div class="likes post-header-likes">
                  <svg width="15" height="15" fill="#BCBFC2" class="icon likes-icon">
                     <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#heart"></use>
                  </svg>
                  <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
               </div>

               <div class="comments post-header-comments">
                  <svg width="15" height="15" fill="#BCBFC2" class="icon comments-icon">
                     <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
                  </svg>
                  <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
               </div>
            </div>
            <!-- /.post-header-info -->

            <div class="post-author">
               <div class="post-author-info">
                  <?php $author_id = get_the_author_meta('ID'); ?>
                  <img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author(); ?>" class="post-author-avatar">
                  <span class="post-author-name"><?php the_author(); ?></span>
                  <span class="post-author-rank">Должность</span>
                  <span class="post-author-posts">
                     <?php plural_form(count_user_posts($author_id),
                     /* варианты написания для количества 1, 2, 5 */
                     array('статья','статьи','статей')) ?>
                  </span>
               </div>
               <!-- /.post-author-info -->

               <a href="<?php echo get_author_posts_url($author_id); ?>" class="post-author-link">
                  Сайт автора
               </a>
            </div>
            <!-- /.post-author -->
         </div>
         <!-- /.post-header-wrapper -->

      </div>
      <!-- /.container -->
            
   </header><!-- .шапка поста -->

   <!-- Содержимое поста -->
   <div class="post-content">
      <div class="container">
         <?php
            the_content(
               sprintf(
                  wp_kses(
                     /* translators: %s: Name of current post. Only visible to screen readers */
                     __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-theme' ),
                     array(
                        'span' => array(
                           'class' => array(),
                        ),
                     )
                  ),
                  wp_kses_post( get_the_title() )
               )
            );

            wp_link_pages(
               array(
                  'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'universal-theme' ),
                  'after'  => '</div>',
               )
            );
         ?>
      </div>
      <!-- .container -->
   </div>
   <!-- .post-content -->

   <footer class="entry-footer">
      <div class="container">
         <?php
            $tags_list = get_the_tag_list( '', esc_html_x('', 'list item separator', 'universal-theme' ) );
            if ( $tags_list ) {
               /* translators: 1: list of tags. */
               printf( '<span class="tags-links">' . esc_html__('%1$s', 'universal-theme' ) . '</span>', $tags_list ); // phpcs:ignore Wordpress. Security.EscapeOutput.OutputNotEscaped
            }

            // Поделиться в соцсетях
            meks_ess_share();
         ?>
      </div>
      <!-- .container -->
	</footer>
   <!-- .entry-footer -->
</article>

<section class="similar-posts">
   <div class="container">
      <div class="similar-posts-wrapper">
         <!-- Секция с одним похожими постами -->
         <?php		
            global $post;

            $query = new WP_Query( [
               'posts_per_page' => 4,
               'category_name'  => 'web-design',
               'post__not_in'   => array(get_the_ID(4))
            ] );

            if ( $query->have_posts() ) {
               while ( $query->have_posts() ) {
                  $query->the_post();
         ?>
            <a href="<?php the_permalink() ?>" class="similar-posts-item">
               <img src="<?php
                  if( has_post_thumbnail() ) {
                     echo get_the_post_thumbnail_url();
                  }
                  else {
                     echo get_template_directory_uri() .'/assets/images/img-default.png';
                  }
               ?>" alt="<?php the_title(); ?>" class="article-thumb">
               <h2 class="similar-posts-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...') ?></h2>

               <div class="similar-posts-reactions">
                  <div class="likes similar-posts-views">
                     <svg width="15" height="15" fill="#BCBFC2" class="icon likes-icon">
                        <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#views"></use>
                     </svg>
                     <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                  </div>

                  <div class="comments similar-posts-comments">
                     <svg width="15" height="15" fill="#BCBFC2" class="icon comments-icon">
                        <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
                     </svg>
                     <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                  </div>
               </div>
               <!-- /.similar-posts-reactions -->
            </a>
            <!-- /.simillar-posts-item -->
         <?php 
               }
            } else {
               // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
         ?>
      </div>
      <!-- /.similar-posts-wrapper -->
      
   </div>
   <!-- /.container -->

</section>
<!-- /.similar-posts -->
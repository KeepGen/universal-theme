<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <!-- выводим шапку поста -->
   <header class="entry-header <?php echo get_post_type(); ?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75));">
         
		<div class="container">
         
         <div class="post-header-wrapper">
            <!-- /.post-header-nav -->
            <div class="video">
               <?php
                  $video_link = get_field('video_link');

                  if (strpos($video_link, 'youtube') !== false) {?>
                     <iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php 
                        $video_link = get_field('video_link');
                        if ($video_link) {
                           $tmp = explode('?v=', get_field('video_link'));
                           echo end ($tmp);
                        }
                        ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                     </iframe><?php
                  };

                  if (strpos($video_link, 'vimeo') !== false) {?>
                     <iframe width="100%" height="450" src="https://player.vimeo.com/video/<?php 
                        $video_link = get_field('video_link');
                        if ($video_link) {
                           $tmp = explode('/', get_field('video_link'));
                           echo end ($tmp);
                        }
                        ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                     </iframe><?php
                  };
               ?>
            </div>
               
            <div class="lesson-header-title-wrapper">
               <?php
                  // проверяем, точно ли мы на странице поста
                  if ( is_singular() ) :
                     the_title( '<h1 class="lesson-header-title">', '</h1>' );
                  else :
                     the_title( '<h2 class="lesson-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                  endif;
               ?>
            </div>

            <div class="post-header-info">
               <div class="post-header-date">
                  <svg width="15" height="15" fill="#BCBFC2" class="icon time-icon">
                     <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#time"></use>
                  </svg>
                  <?php the_time('j F, G:i'); ?>
               </div>

            </div>
            <!-- /.post-header-info -->

            <div class="taxonomy-list">
               <?php _e( 'Lesson tags: ', 'universal' ) . the_terms(get_the_ID(), 'genre', '', ', ', ''); ?>
            </div>

            <div class="taxonomy-list">
               <?php _e( 'Teacher(s): ', 'universal' ) . the_terms(get_the_ID(), 'teacher', '', ' / ', ''); ?>
            </div>
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
                     __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal' ),
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
                  'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universal' ),
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
            $tags_list = get_the_tag_list( '', esc_html_x('', 'list item separator', 'universal' ) );
            if ( $tags_list ) {
               /* translators: 1: list of tags. */
               printf( '<span class="tags-links">' . esc_html__('%1$s', 'universal' ) . '</span>', $tags_list ); // phpcs:ignore Wordpress. Security.EscapeOutput.OutputNotEscaped
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
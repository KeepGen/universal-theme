<?php get_header();?>
<main class="front-page-header">
   <div class="container">
      <div class="hero">
         <div class="left">
            <?php
            // Announcing global variable
            global $post;

            $myposts = get_posts([ 
               'numberposts' => 1,
            ]);

            // Checking if posts exist
            if( $myposts ){
               // If exist, start loop
               foreach( $myposts as $post ){
                  setup_postdata( $post );
            ?>
            <!-- Выводим записи -->
            <img src="<?php the_post_thumbnail_url() ?>" alt="" class="post-thumb">
            <?php $author_id = get_the_author_meta('ID'); ?>
            <a href="<?php echo get_author_posts_url($author_id); ?>" class="author">
               <img src="<?php echo get_avatar_url($author_id) ?>" alt="" class="avatar">
               <div class="author-bio">
                  <span class="author-name"><?php the_author(); ?></span>
                  <span class="author-rank">Должность</span>
               </div>
            </a>
            <div class="post-text">
               <?php the_category(); ?>
               <h2 class="post-title"><?php the_title(); ?></h2>
               <a href="<?php echo get_the_permalink() ?>" class="more">Читать далее</a>
            </div>
            <?php 
                  }
               } else {
                  ?><p>Постов нет</p><?php
               }

               wp_reset_postdata(); // Сбрасываем $post
            ?>
         </div>
         <!-- /.left -->
         <div class="right">
            <h3 class="recommend">Рекомендуем</h3>
            <ul class="posts-list">
               <?php
                  // Announcing global variable
                  global $post;

                  $myposts = get_posts([ 
                     'numberposts' => 5,
                     'offset' => 1,
                  ]);

                  // Checking if posts exist
                  if( $myposts ){
                     // If exist, start loop
                     foreach( $myposts as $post ){
                        setup_postdata( $post );
               ?>
               <!-- Выводим записи -->
               <li class="post">
                  <?php the_category(); ?>
                  <a class="post-permalink" href="<?php echo get_the_permalink(); ?>">
                  <h4 class="post-title"><?php the_title(); ?></h4>
                  </a>
               </li>
               <?php 
                     }
                  } else {
                     ?><p>Постов нет</p><?php
                  }

                  wp_reset_postdata(); // Сбрасываем $post
               ?>
            </ul>
         </div>
         <!-- /.right -->
      </div>
      <!-- /.hero -->
   </div>
   <!-- /.container -->
</main>
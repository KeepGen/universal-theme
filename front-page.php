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
               'category_name' => 'web-design',
            ]);

            // Checking if posts exist
            if( $myposts ){
               // If exist, start loop
               foreach( $myposts as $post ){
                  setup_postdata( $post );
            ?>
            <!-- Выводим записи -->
            <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title(); ?>" class="post-thumb">
            <?php $author_id = get_the_author_meta('ID'); ?>
            <a href="<?php echo get_author_posts_url($author_id); ?>" class="author">
               <img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author(); ?>" class="avatar">
               <div class="author-bio">
                  <span class="author-name"><?php the_author(); ?></span>
                  <span class="author-rank"><?php 
                     // получаем список ролей
                     $roles = wp_roles()->roles;
                     // узнаем текущую роль пользователя
                     $current_role = get_the_author_meta('roles', $author_id)[0];
                     // перебираем все роли
                     foreach ($roles as $role =>$value) {
                        // если наша текущая роль совпадает с ролью из списка
                        if($role == $current_role) {
                           // выводим роль
                           echo $value['name'];
                        }
                     } ?>
                  </span>
               </div>
            </a>
            <div class="post-text">
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
               <h2 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 41, '...') ?></h2>
               <a href="<?php echo get_the_permalink() ?>" class="more"><?php _e( 'Read more', 'universal' ) ?></a>
            </div>
            <?php 
                  }
               } else {
                  ?><p><?php _e( 'No posts', 'universal' ) ?></p><?php
               }

               wp_reset_postdata(); // Сбрасываем $post
            ?>
         </div>
         <!-- /.left -->
         <div class="right">
            <h3 class="recommend"><?php _e( 'Recommend', 'universal' ) ?></h3>
            <ul class="posts-list">
               <?php
                  // Announcing global variable
                  global $post;

                  $myposts = get_posts([ 
                     'numberposts' => 5,
                     'offset' => 1,
                     'category_name' => 'javascript, html, css, web-design',
                  ]);

                  // Checking if posts exist
                  if( $myposts ){
                     // If exist, start loop
                     foreach( $myposts as $post ){
                        setup_postdata( $post );
               ?>
               <!-- Выводим записи -->
               <li class="post">
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
                  <a class="post-permalink" href="<?php echo get_the_permalink(); ?>">
                  <h4 class="post-title"><?php echo wp_trim_words( get_the_title(), 8, '...' ) ?></h4>
                  </a>
               </li>
               <?php 
                     }
                  } else {
                     ?><p><?php _e( 'No posts', 'universal' ) ?></p><?php
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

<div class="container">
   <ul class="article-list">
      <?php
         // Announcing global variable
         global $post;

         $myposts = get_posts([ 
            'numberposts' => 4,
            'category_name' => 'articles',
         ]);

         // Checking if posts exist
         if( $myposts ){
            // If exist, start loop
            foreach( $myposts as $post ){
               setup_postdata( $post );
      ?>
      <!-- Выводим записи -->
      <li class="article-item">
         <a class="article-permalink" href="<?php echo get_the_permalink(); ?>">
         <h4 class="article-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...') ?></h4>
         </a>
         <img width="65" height="65" src="<?php if( has_post_thumbnail() ) {
                     echo get_the_post_thumbnail_url(null, 'thumb');
                  }
                  else {
                     echo get_template_directory_uri() .'/assets/images/img-default.png';
                  } ?>" alt="<?php the_title(); ?>">
      </li>
      <?php 
            }
         } else {
            ?><p><?php _e( 'No posts', 'universal' ) ?></p><?php
         }
         wp_reset_postdata(); // Сбрасываем $post
      ?>
   </ul>
   <!-- /.article-list -->

   <div class="main-grid">
      <ul class="article-grid">
         <?php		
            global $post;
            // формируем запрос в базу данных
            $query = new WP_Query( [
               // получаем кол-во постов
               'posts_per_page' => 7,
               'category__not_in' => 1,
            ] );
               // проверяем, есть ли посты
            if ( $query->have_posts() ) {
               // создаем переменную-счетчик постов
               $cnt = 0;
               // пока посты есть, выводим их
               while ( $query->have_posts() ) {
                  $query->the_post();
                  // увеличиваем счетчик постов
                  $cnt++;
                  switch ($cnt) {
                     // выводим первый пост
                     case '1':
                        ?>
                           <li class="article-grid-item article-grid-item-1">
                              <a href="<?php the_permalink() ?>" class="article-grid-permalink">
                                 <span class="category-name">
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
                                 </span>
                                 <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 55, '...') ?></h4>
                                 <p class="article-grid-excerpt">
                                    <?php echo mb_strimwidth(get_the_excerpt(), 0, 170, '...') ?>
                                 </p>
                                 <div class="article-grid-info">
                                    <div class="author">
                                       <?php $author_id = get_the_author_meta('ID'); ?>
                                       <img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author(); ?>" class="author-avatar">
                                       <span class="author-name"><strong><?php the_author()?></strong>: <?php the_author_meta('description')?></span>
                                    </div>
                                    <div class="comments">
                                       <svg width="19" height="15" fill="#BCBFC2" class="icon comments-icon">
                                          <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
                                       </svg>
                                       <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                    </div>
                                 </div>
                              </a>
                           </li>
                        <?php 
                        break;
                     
                     // выводим второй пост
                     case '2':
                        ?>
                           <li class="article-grid-item article-grid-item-2">
                              <img src="<?php if( has_post_thumbnail() ) {
                              echo get_the_post_thumbnail_url();
                           }
                           else {
                              echo get_template_directory_uri() .'/assets/images/img-default.png';
                           } ?>" alt="<?php get_the_title() ?>" class="article-grid-thumb">
                              <a href="<?php the_permalink() ?>" class="article-grid-permalink">
                                 <span class="tag">
                                    <?php $posttags = get_the_tags();
                                    if ( $posttags ) {
                                       echo $posttags[2]->name . '';
                                    } ?>
                                 </span>
                                 <span class="category-name"><?php $category = get_the_category(); echo $category [0]->name; ?></span>
                                 <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 75, '...') ?></h4>
                                 <div class="article-grid-info">
                                    <div class="author">
                                       <?php $author_id = get_the_author_meta('ID'); ?>
                                       <img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author(); ?>" class="author-avatar">
                                       <div class="author-info">
                                          <span class="author-name"><strong><?php the_author()?></strong></span>
                                          <span class="date"><?php the_time('j F'); ?></span>
                                          <div class="comments">
                                             <svg width="19" height="15" fill="#FFFFFF" class="icon comments-icon">
                                                <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
                                             </svg>
                                             <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                          </div>

                                          <div class="likes">
                                             <svg width="19" height="15" fill="#ffffff" class="icon comments-icon">
                                                <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#heart"></use>
                                             </svg>
                                             <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                                          </div>
                                       </div>
                                       <!-- author-info -->
                                    </div>
                                    <!-- author -->
                                 </div>
                                 <!-- article-grid-info -->
                              </a>
                           </li>
                        <?php
                     break;

                     // выводим третий пост
                     case '3':
                        ?>
                           <li class="article-grid-item article-grid-item-3">
                              <a href="<?php the_permalink() ?>" class="article-grid-permalink">
                                 <img src="<?php if( has_post_thumbnail() ) {
                                    echo get_the_post_thumbnail_url();
                                 }
                                 else {
                                    echo get_template_directory_uri() .'/assets/images/img-default.png';
                                 } ?>" alt="<?php the_title(); ?>" class="article-thumb">
                                 <h4 class="article-grid-title"><?php echo get_the_title() ?></h4>
                              </a>
                           </li>
                        <?php
                     break;
                     
                     // выводим остальные посты
                     default:
                        ?>
                        <li class="article-grid-item article-grid-item-default">
                           <a href="<?php the_permalink() ?>" class="article-grid-permalink">
                              <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 20, '...') ?></h4>
                              <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 70, '...') ?></p>
                              <span class="article-date"><?php the_time('j F'); ?></span>
                           </a>
                        </li>
                        <?php
                     break;
                  }
                  ?>
                  <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                  <?php 
               }
            } else {
               // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
         ?>
      </ul>
      <!-- /.article-grid -->
      
      <!-- Подключаем верхний сайдбар -->
      <?php get_sidebar('home-top'); ?>
   </div>
</div>
<!-- /.container -->

<!-- Секция с одним постом на фоновой картинке -->
<?php		
   global $post;

   $query = new WP_Query( [
      'posts_per_page' => 1,
      'category_name' => 'investigation',
   ] );

   if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
         $query->the_post();
         ?>
         
         <section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)), url(<?php if( has_post_thumbnail() ) {
               echo get_the_post_thumbnail_url();
            }
            else {
               echo get_template_directory_uri() .'/assets/images/img-default.png';
            }?>) no-repeat center center">
            <div class="container">
               <h2 class="investigation-title"><?php the_title(); ?></h2>
               <a href="<?php echo get_the_permalink() ?>" class="more"><?php _e( 'Read more', 'universal' ) ?></a>
            </div>
         </section>

         <?php 
      }
   } else {
      // Постов не найдено
   }

   wp_reset_postdata(); // Сбрасываем $post
?>
<!-- /.investigation -->

<div class="container">
   <div class="latest-articles">
      <div class="latest-articles-wrapper">
         <div class="latest-articles-main">
            <ul class="post-list">
               <?php
                  global $post;
                  $myposts = get_posts([ 
                     'numberposts'    => 6,
                     'category_name'  => 'hot, opinions, news, specials',
                  ]);
                  if( $myposts ){
                     foreach( $myposts as $post ){
                        setup_postdata( $post );
               ?>
            
               <li class="post">
                  <img src="<?php
                  if( has_post_thumbnail() ) {
                     echo get_the_post_thumbnail_url();
                  }
                  else {
                     echo get_template_directory_uri() .'/assets/images/img-default.png';
                  }
                  ?>" alt="<?php the_title(); ?>" class="article-thumb">

                  <div class="post-info">
                     <div class="category-bookmark">
                        <span class="category-name">
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
                        </span>
                        <svg width="14" height="18" fill="#BCBFC2" class="icon comments-icon">
                           <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#bookmark"></use>
                        </svg>
                     </div>
                     <!-- /.category-bookmark -->
                     <a href="<?php the_permalink() ?>" class="latest-article-permalink">
                        <h4 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 65, '...') ?></h4>
                        <div class="post-preview"><?php echo mb_strimwidth(get_the_excerpt(), 0, 190, '...') ?></div>
                        <div class="post-details">
                           <span class="date"><?php the_time('j F'); ?></span>
                           <div class="comments">
                              <svg width="19" height="15" fill="#BCBFC2" class="icon comments-icon">
                                 <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
                              </svg>
                              <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                           </div>

                           <div class="likes">
                              <svg width="19" height="15" fill="#BCBFC2" class="icon comments-icon">
                                 <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#heart"></use>
                              </svg>
                              <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                           </div>
                        </div>
                        <!-- /.post-details -->
                     </a>
                  </div>
                  <!-- /.post-info -->
                  
               </li>
               
               <?php 
                     }
                  } else {
                     // Постов не найдено
                  }
                  wp_reset_postdata(); // Сбрасываем $post
               ?>
            </ul>
            <!-- /.post-list -->
         </div>
         <!-- /.latest-articles-main -->
      </div>
      <!-- /.last-articles-wrapper -->

      <!-- Подключаем верхний сайдбар -->
      <?php get_sidebar('home-bottom'); ?>
   </div>
   <!-- /.latest-articles -->
</div>
<!-- /.container -->

<div class="special">
   <div class="container">
      <div class="special-grid">
         <?php		
            global $post;

            $query = new WP_Query( [
               'posts_per_page' => 1,
               'category_name' => 'photo-report',
            ] );

            if ( $query->have_posts() ) {
               while ( $query->have_posts() ) {
                  $query->the_post();
                  ?>
               <div class="photo-report">
                  <!-- Slider main container -->
                  <div class="swiper-container photo-report-slider">
                     <!-- Additional required wrapper -->
                     <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php $images =get_attached_media ('image');
                           foreach ($images as $image ) {
                              echo '<div class="swiper-slide"><img src="';
                              print_r ($image -> guid);
                              echo '"></div>';
                           }
                        ?>
                     </div>
                     <div class="swiper-pagination"></div>
                  </div>

                  <div class="photo-report-content">
                     <?php
                        foreach (get_the_category() as $category){
                           printf(
                              '<a href="%s" class="category-link">%s</a>',
                              esc_url( get_category_link( $category ) ),
                              esc_html( $category -> name),
                           );
                        }
                     ?>

                     <?php $author_id = get_the_author_meta('ID'); ?>
                     <a href="<?php echo get_author_posts_url($author_id); ?>" class="author">
                        <img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author(); ?>" class="author-avatar">
                        <div class="author-bio">
                           <span class="author-name"><?php the_author(); ?></span>
                           <span class="author-rank"><?php 
                              // получаем список ролей
                              $roles = wp_roles()->roles;
                              // узнаем текущую роль пользователя
                              $current_role = get_the_author_meta('roles', $author_id)[0];
                              // перебираем все роли
                              foreach ($roles as $role =>$value) {
                                 // если наша текущая роль совпадает с ролью из списка
                                 if($role == $current_role) {
                                    // выводим роль
                                    echo $value['name'];
                                 }
                              } ?>
                           </span>
                        </div>
                     </a>
                     <h3 class="photo-report-title"><?php the_title(); ?></h3>
                     <a href="<?php echo get_the_permalink() ?>" class="button photo-report-button">
                        <svg width="19" height="15" class="icon photo-report-icon">
                           <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#images"></use>
                        </svg>
                        <?php _e( 'Watch photo', 'universal' ) ?>
                        <span class="photo-report-counter"><?php echo count($images)?></span>
                     </a>
                  </div>
                  <!-- /.photo-report-content -->
               </div>
               <!-- /.photo-report -->

               <?php 
               }
            } else {
               // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
         ?>
         
         <div class="other">
            <!-- <div class="career"></div> -->

            <ul class="career-grid">
               <?php		
                  global $post;
                  // формируем запрос в базу данных
                  $query = new WP_Query( [
                     // получаем кол-во постов
                     'posts_per_page' => 3,
                     'category_name' => 'career',
                  ] );
                     // проверяем, есть ли посты
                  if ( $query->have_posts() ) {
                     // создаем переменную-счетчик постов
                     $cnt = 0;
                     // пока посты есть, выводим их
                     while ( $query->have_posts() ) {
                        $query->the_post();
                        // увеличиваем счетчик постов
                        $cnt++;
                        switch ($cnt) {
                           // выводим первый пост
                           case '1':
                              ?>
                                 <li class="career-grid-item career-grid-item-1">
                                 <img src="<?php echo get_template_directory_uri() . '/assets/images/career-photo.png'?>" alt="<?php get_the_title() ?>" class="career-grid-item-1-bg">
                                 <a href="<?php the_permalink() ?>" class="career-grid-permalink">
                                    <?php
                                       foreach (get_the_category() as $category){
                                          printf(
                                             '<a href="%s" class="category-link">%s</a>',
                                             esc_url( get_category_link( $category ) ),
                                             esc_html( $category -> name),
                                          );
                                       }
                                    ?>
                                    </a>

                                    <h4 class="career-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 55, '...') ?></h4>
                                    <p class="career-grid-excerpt">
                                       <?php echo mb_strimwidth(get_the_excerpt(), 0, 170, '...') ?>
                                    </p>
                                    <a href="<?php echo get_the_permalink() ?>" class="more"><?php _e( 'Read more', 'universal' ) ?></a>
                                 </li>
                              <?php 
                           break;
                           
                           // выводим остальные посты
                           default:
                              ?>
                              <li class="career-grid-item career-grid-item-default">
                                 <a href="<?php the_permalink() ?>" class="career-grid-permalink">
                                    <h4 class="career-grid-title-mini"><?php echo mb_strimwidth(get_the_title(), 0, 20, '...') ?></h4>
                                    <p class="career-grid-excerpt-mini"><?php echo mb_strimwidth(get_the_excerpt(), 0, 70, '...') ?></p>
                                    <span class="career-date"><?php the_time('j F'); ?></span>
                                 </a>
                              </li>
                              <?php
                           break;
                        }
                        ?>
                        <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                        <?php 
                     }
                  } else {
                     // Постов не найдено
                  }

                  wp_reset_postdata(); // Сбрасываем $post
               ?>
            </ul>
            <!-- /.article-grid -->

         </div>
         <!-- /.other -->
      </div>
      <!-- /.special-grid -->
   </div>
</div>
<!-- /.special -->

<?php get_footer(); ?>
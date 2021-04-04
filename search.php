<?php get_header(); ?>
   <div class="search-section">
      <div class="container">

         <h1 class="search-title">Результаты поиска по&nbsp;запросу:</h1>
         <div class="latest-articles">
            <div class="latest-articles-wrapper">
               <div class="latest-articles-main">
                  <ul class="post-list">
                     <?php while ( have_posts() ){ the_post(); ?>

                     <li class="post">
                        <a href="<?php the_permalink() ?>" class="latest-article-permalink">
                        <img src="<?php
                        if( has_post_thumbnail() ) {
                           echo get_the_post_thumbnail_url();
                        }
                        else {
                           echo get_template_directory_uri() .'/assets/images/img-default.png';
                        }
                        ?>" alt="<?php the_title(); ?>" class="article-thumb">
                           <div class="post-info">
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
                           </div>
                           <!-- /.post-info -->
                        </a>
                     </li>

                     <?php  } if  ( ! have_posts() ) { ?>
                        К сожалению, по вашему запорсу записей нет... Попробуйте поискать что-нибудь другое.
                     <?php } ?>
                  </ul>
                  <!-- /.post-list -->

               </div>
               <!-- /.latest-articles-main -->

               <div class="pagination-wrapper">
               </div>
                  <?php
                  $args = array (
                     'prev_text' => '<div class="grey-icons">&larr;</div> Назад',
                     'next_text' => 'Вперед <div class="grey-icons">&rarr;</div>',
                  );
                  the_posts_pagination( $args ) ?>
               </div>
            <!-- /.latest-articles-wrapper -->

            <!-- Подключаем верхний сайдбар -->
            <?php get_sidebar('home-bottom'); ?>

         </div>
         <!-- /.latest-articles -->

      </div>
      <!-- /.container -->
   </div>
   <!-- /.search-section -->

<?php get_footer(); ?>
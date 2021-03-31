<?php get_header(); ?>

<div class="container">

   <h1 class="category-title">
      Результаты по метке "<?php single_cat_title() ?>"
   </h1>

   <div class="post-list">
      <?php while ( have_posts() ){ the_post(); ?>
         <div class="post-card">
            <a href="<?php the_permalink() ?>" class="post-card-permalink">
               <img src="<?php if( has_post_thumbnail() ) {
                     echo get_the_post_thumbnail_url(null, 'thumb');
                  }
                  else {
                     echo get_template_directory_uri() .'/assets/images/img-default.png';
                  } ?>" alt="<?php the_title(); ?>" alt="<?php the_title(); ?>" class="post-card-thumb">
            
               <div class="post-card-text">
                  <h2 class="post-card-title"><?php echo mb_strimwidth(get_the_title(), 0, 38, '...') ?></h2>
                  <p class="post-card-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 80, '...') ?></p>

                  <div class="author">
                     <?php $author_id = get_the_author_meta('ID'); ?>
                     <img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author(); ?>" class="author-avatar">
                     <div class="author-info">
                        <span class="author-name"><strong><?php the_author()?></strong></span>
                        <span class="date"><?php the_time('j M'); ?></span>
                        <div class="comments">
                           <svg width="15" height="15" fill="#BCBFC2" class="icon comments-icon">
                              <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
                           </svg>
                           <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                        </div>

                        <div class="likes">
                           <svg width="15" height="15" fill="#BCBFC2" class="icon comments-icon">
                              <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#heart"></use>
                           </svg>
                           <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                        </div>
                     </div>
                     <!-- author-info -->
                  </div>
                  <!-- author -->
               </div>
               <!-- /.post-card-text -->
            </a>

         </div>
         <!-- /.card -->
      <?php } ?>
      <?php if ( ! have_posts() ){ ?>
         Записей нет.
      <?php } ?>

      <?php
         $args = array (
            'prev_text' => '<div class="grey-icons">&larr;</div> Назад',
            'next_text' => 'Вперед <div class="grey-icons">&rarr;</div>',
         );
      the_posts_pagination( $args ) ?>
      
   </div>
   <!-- /.posts-list -->
   
   <h1>taxonomy.php</h1>

</div>
<!-- /.container -->

<?php get_footer(); ?>

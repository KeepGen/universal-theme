<?php get_header(); ?>

   <div class="container">

      <?php while ( have_posts() ){ the_post(); ?>      

         <?php 
            $terms = get_terms ( array(
               'taxonomy' => 'lesson',
               'hide_empty' => false, ) );

            $args = array ('post_type' => 'lesson', 'post_per_page' => 10);
            $loop = new WP_Query($args);
            while ($loop->have_posts() ) : $loop->the_post();
         ?>

         <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

         <?php 
            echo '<div class="entry-content">';
               the_content();
               echo '</div>';
            endwhile;
         ?>
      
      <?php } if ( ! have_posts() ) { ?>
         <p>Записей нет.</p>
      <?php } ?>

      <h1>archive.php</h1>
      
   </div>

<?php get_footer(); ?>

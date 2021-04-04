<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package universal-theme
 */

get_header();
?>

	<div class="container">
      <main id="primary" class="site-main page404">

         <section class="error-404 not-found">
            <h1 class="page404-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'universal' ); ?></h1>

            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'universal' ); ?></p>

            <div class="page404-content">

               <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

               <div class="widget widget_categories widget_categories__search">
                  <h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'universal' ); ?></h2>
                  <ul>
                     <?php
                     wp_list_categories(
                        array(
                           'orderby'    => 'count',
                           'order'      => 'DESC',
                           'show_count' => 1,
                           'title_li'   => '',
                           'number'     => 10,
                        )
                     );
                     ?>
                  </ul>
               </div>
               <!-- .widget -->
               
               <?php
               /* translators: %1$s: smiley */
               $universal_example_archive_content = '<p class="archive_search">' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'universal' ), convert_smilies( ':)' ) ) . '</p>';
               the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$universal_example_archive_content" ); '</div>'
               ?>
               
               <?php
               the_widget( 'WP_Widget_Tag_Cloud' );
               ?>

            </div><!-- .page404-content -->
         </section><!-- .error-404 -->

      </main><!-- #main -->
   </div>
   <!-- .container -->

<?php
get_footer();

<?php
/*
Template Name: Страница Контакты
Template Post Type: page
*/

get_header();
?>

<section class="section-dark">
   <div class="container">
      <?php the_title('<h1 class="page-title">', '</h1>', true); ?>
      <div class="contacts-wrapper">
         <div class="left">
            <p class="page-text">Через форму обратной связи (php-обработчик)</p>
            <form action="form.php" class="contacts-form" method="POST">
               <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
               <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email">
               <textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
               <button type="submit" class="button more">Отправить</button>
            </form>
         </div>
         <!-- /.left -->
         <div class="right">
            <p class="page-text">Через форму обратной связи (форма CF7)</p>
            <?php echo do_shortcode( '[contact-form-7 id="178" title="Контактная форма"]' ) ?>
         </div>
         <!-- /.right -->
      </div>
   </div>
   <!-- /.container -->
</section>
<!-- /.section-dark -->

<?php
get_footer();
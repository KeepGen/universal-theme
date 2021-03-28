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
            <h2 class="contacts-title">Через форму обратной связи</h2>
            <!-- <form action="form.php" class="contacts-form" method="POST">
               <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
               <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email">
               <textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
               <button type="submit" class="button more">Отправить</button>
            </form> -->
            <?php the_content()?>
         </div>
         <!-- /.left -->
         <div class="right">
             <h2 class="contacts-title">Или по этим данным:</h2>
             <a href="mailto:<?php the_field('email') ?>"><?php echo the_field('email') ?></a>
             <address><?php echo the_field('address') ?></address>
             <a href="tel:<?php the_field('phone') ?>"><?php echo the_field('phone') ?></a>
         </div>
         <!-- /.right -->
      </div>
   </div>
   <!-- /.container -->
</section>
<!-- /.section-dark -->

<?php
get_footer();
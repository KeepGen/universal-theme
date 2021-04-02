<?php
// Adding extended features
if ( ! function_exists ( 'universal_theme_setup' ) ) :

  function universal_theme_setup() {

	// Удаляем роль при деактивации нашей темы
	add_action( 'switch_theme', 'deactivate_universal_theme' );
	function deactivate_universal_theme() {
		remove_role( 'developer' );
	}

	// Добавляем роль при активации нашей темы
	add_action( 'after_switch_theme', 'activate_universal_theme' );
	function activate_universal_theme() {
		$author = get_role( 'author' );
		add_role( 'developer', 'Разработчик', $author->capabilities);
		add_role( 'designer', 'Дизайнер', $author->capabilities);
		add_role( 'photographer', 'Фотограф', $author->capabilities);
	}

	 // Подключение файлов перевода
	 load_theme_textdomain( 'universal', get_template_directory() . '/languages' );

    // Adding title tag
    add_theme_support( 'title-tag' );

    // Adding thumbnails
    add_theme_support( 'post-thumbnails', array( 'post', 'lesson' ) );

    // Adding Website Logo
    add_theme_support( 'custom-logo', [
      'width'       => 163,
      'flex-height' => true,
      'header-text' => 'Universal Logo',
      'unlink-homepage-logo' => true, // WP 5.5
    ] );

    // Adding header menu
    register_nav_menus( [
      'header_menu' => 'Header menu',
      'footer_menu' => 'Footer menu'
    ] );

	add_action( 'init', 'register_post_types' );
	function register_post_types(){
		register_post_type( 'lesson', [
			'label'  => null,
			'labels' => [
				'name'               => __( 'Lessons', 'universal' ), // основное название для типа записи
				'singular_name'      => __( 'Lesson', 'universal' ), // название для одной записи этого типа
				'add_new'            => __( 'Add new lesson', 'universal' ), // для добавления новой записи
				'add_new_item'       => __( 'Add a new lesson', 'universal' ), // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование урока', // для редактирования типа записи
				'new_item'           => __( 'New lesson', 'universal' ), // текст новой записи
				'view_item'          => __( 'View lesson', 'universal' ), // для просмотра записи этого типа.
				'search_items'       => __( 'Search lesson', 'universal' ), // для поиска по этим типам записи
				'not_found'          => __( 'Not Found', 'universal' ), // если в результате поиска ничего не было найдено
				'not_found_in_trash' => __( 'Not found in trash bin', 'universal' ), // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => __( 'Lessons', 'universal' ), // название меню
			],
			'description'         => __( 'Video tutorials section', 'universal' ),
			'public'              => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			// 'show_ui'             => null, // зависит от public
			// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'        => true, // показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => true, // добавить в REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-welcome-learn-more',
			'capability_type'     => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false,
			'supports'            => array('title', 'editor', 'thumbnail', 'author', 'custom-fields' ), // 'title','editor','author','excerpt','trackbacks','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => [],
			'has_archive'         => false,
			'rewrite'             => true,
			'query_var'           => true,
		] );
	}

	// хук, через который подключается функция
	// регистрирующая новые таксономии (create_lesson_taxonomies)
	add_action( 'init', 'create_lesson_taxonomies' );

	// функция, создающая 2 новые таксономии "genres" и "theachers" для постов типа "book"
	function create_lesson_taxonomies(){
		// Добавляем древовидную таксономию 'genre' (как категории)
		register_taxonomy('genre', array('lesson'), array(
			'hierarchical'  => true,
			'labels'        => array(
				'name'              => _x( 'Genres', 'taxonomy general name', 'universal' ),
				'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'universal' ),
				'search_items'      =>  __( 'Search Genres', 'universal' ),
				'all_items'         => __( 'All Genres', 'universal' ),
				'parent_item'       => __( 'Parent Genre', 'universal' ),
				'parent_item_colon' => __( 'Parent Genre:', 'universal' ),
				'edit_item'         => __( 'Edit Genre', 'universal' ),
				'update_item'       => __( 'Update Genre', 'universal' ),
				'add_new_item'      => __( 'Add New Genre', 'universal' ),
				'new_item_name'     => __( 'New Genre Name', 'universal' ),
				'menu_name'         => __( 'Genre', 'universal' ),
			),
			'show_ui'       => true,
			'query_var'     => true,
			'rewrite'       => array( 'slug' => 'the_genre' ), // свой слаг в URL
		));

		// Добавляем НЕ древовидную таксономию 'teacher' (как метки)
		register_taxonomy('teacher', 'lesson', array(
			'hierarchical'  => false,
			'labels'        => array(
				'name'                        => _x( 'Teachers', 'taxonomy general name', 'universal' ),
				'singular_name'               => _x( 'Teacher', 'taxonomy singular name', 'universal' ),
				'search_items'                =>  __( 'Search Teachers', 'universal' ),
				'popular_items'               => __( 'Popular Teachers', 'universal' ),
				'all_items'                   => __( 'All Teachers', 'universal' ),
				'parent_item'                 => null,
				'parent_item_colon'           => null,
				'edit_item'                   => __( 'Edit Teacher', 'universal' ),
				'update_item'                 => __( 'Update Teacher', 'universal' ),
				'add_new_item'                => __( 'Add New Teacher', 'universal' ),
				'new_item_name'               => __( 'New Teacher Name', 'universal' ),
				'separate_items_with_commas'  => __( 'Separate Teachers with commas', 'universal' ),
				'add_or_remove_items'         => __( 'Add or remove Teachers', 'universal' ),
				'choose_from_most_used'       => __( 'Choose from the most used Teachers', 'universal' ),
				'menu_name'                   => __( 'Teachers', 'universal' ),
			),
			'show_ui'       => true,
			'query_var'     => true,
			'rewrite'       => array( 'slug' => 'the_teacher' ), // свой слаг в URL
		));
	}

}
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );

// Connecting styles and scripts
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'swiper-slider', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', 'style', time());
  wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style', time());
  wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
  wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.6.0.min.js');
	wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, time(), true);
  wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', 'swiper', time(), true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );


// Подключаем скрипт для AJAX
add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){
	wp_localize_script( 'jquery', 'adminAjax', 
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);  

}

add_action('wp_ajax_contacts_form', 'ajax_form');
add_action('wp_ajax_nopriv_contacts_form', 'ajax_form');
function ajax_form() {
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_comment = $_POST['contact_comment'];
	$message = __( 'User ', 'universal' ) . $contact_name .__( ' left his details: ', 'universal' ) . $contact_comment;

	$headers = 'From: Роберт Масляков <robertmass@mail.com>' . "\r\n" ;
	$send_message = wp_mail('keepgen@yandex.com', __( 'New application from the website', 'universal' ), $message, $headers);
	if ($send_message) {
		echo __( 'Everything is OK!', 'universal' );
	} else {
		echo __( 'Somewhere we have an error :(', 'universal' );
	}
	wp_die();
}


/**
 * Подключение сайдбара.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar on top front-end', 'universal' ),
			'id'            => 'main-sidebar-top',
			'description'   => esc_html__( 'Add a widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar on bottom front-end', 'universal' ),
			'id'            => 'main-sidebar-bottom',
			'description'   => esc_html__( 'Add a widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Menu in the footer', 'universal' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Add a menu here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-menu-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Text in the footer', 'universal' ),
			'id'            => 'sidebar-footer-text',
			'description'   => esc_html__( 'Add a widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Widget on the search page', 'universal' ),
			'id'            => 'sidebar-search',
			'description'   => esc_html__( 'Add a widget here', 'universal' ),
			'before_widget' => '<section id="%1$s" class="search-text %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );

/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => __( 'Files for download', 'universal' ), 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$description = $instance['description'];
		$link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}		
    if ( ! empty( $description ) ) {
			echo '<p class="description">' . $description . '</p>';
		}		
    if ( ! empty( $link ) ) {
			echo '<a target=_"blank" class="widget-link" href="' . $link . '">
			<img class="widget-link-icon" src=" ' . get_template_directory_uri(  ) . '/assets/images/download.svg">' . __('Download now', 'universal') . '</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: __( 'Useful files', 'universal' );
		$description = @ $instance['description'] ?: __( 'Useful files', 'universal' );
		$link = @ $instance['link'] ?: 'https://yandex.ru';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link to the file:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
    
		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );


/**
 * Добавление нового виджета Social_Widget.
 */
class Social_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Социальные сети',
			array( 'description' => __( 'Links to social networks', 'universal'), 'classname' => 'widget-social', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$facebook = $instance['facebook'];
		$instagram = $instance['instagram'];
		$youtube = $instance['youtube'];
		$twitter = $instance['twitter'];
		
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div class="social-widget-wrapper">';
		if ( ! empty( $facebook ) ) {
			echo '<a target="_blank" class="social-link" href="' . $facebook . '">
			<img class="social-logo" src=" ' . get_template_directory_uri() . '/assets/images/facebook-logo.svg">
			</a>';
		}
		if ( ! empty( $instagram ) ) {
			echo '<a target="_blank" class="social-link" href="' . $instagram . '">
			<img class="social-logo" src=" ' . get_template_directory_uri() . '/assets/images/instagram-logo.svg">
			</a>';
		}
		if ( ! empty( $youtube ) ) {
			echo '<a target="_blank" class="social-link" href="' . $youtube . '">
			<img class="social-logo" src=" ' . get_template_directory_uri() . '/assets/images/youtube-logo.svg">
			</a>';
		}
		if ( ! empty( $twitter ) ) {
			echo '<a target="_blank" class="social-link" href="' . $twitter . '">
			<img class="social-logo" src=" ' . get_template_directory_uri() . '/assets/images/twitter-logo.svg">
			</a>';
		}
		echo '</div>';
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: __( 'Title name', 'universal');
		$facebook = @ $instance['facebook'] ?: 'https://';
		$instagram = @ $instance['instagram'] ?: 'https://';
		$youtube = @ $instance['youtube'] ?: 'https://';
		$twitter = @ $instance['twitter'] ?: 'https://';
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Link to Facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Link to Instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Link to YouTube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Link to Twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация Social_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );


/**
 * Добавление нового виджета Recent_Post_Widget.
 */
class Recent_Post_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_post_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: recent_post_widget
			__( 'Recently posted', 'universal'),
			array( 'description' => __( 'Recent posts', 'universal'), 'classname' => 'widget-recent-posts', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_post_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_post_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$count = $instance['count'];

		echo $args['before_widget'];
		
		if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="widget-recent-posts-wrapper">';
			global $post;
			$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' ) );
			foreach ( $postslist as $post ){
				setup_postdata($post);
				?>
				<a href="<?php the_permalink()?>" class="recent-post-link">
					<img src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail')?>" alt="<?php the_title(); ?>">
					<div class="recent-post-info">
						<h4 class="recent-post-title"><?php echo mb_strimwidth(get_the_title(), 0, 35, '...') ?></h4>
						<span class="recent-post-time">
							<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
							echo " $time_diff "; ?><?php _e( 'ago', 'universal'); ?>
						</span>
					</div>
				</a>
				<?php
			}
			wp_reset_postdata();
			echo '</div>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: __( 'Recently posted', 'universal');
		$count = @ $instance['count'] ?: '7';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Posts quantity:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
    
		return $instance;
	}

	// скрипт виджета
	function add_recent_post_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_recent_post_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('recent_post_widget_script', $theme_url .'/recent_post_widget_script.js' );
	}

	// стили виджета
	function add_recent_post_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_recent_post_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Recent_Post_Widget

// регистрация Recent_Post_Widget в WordPress
function register_recent_post_widget() {
	register_widget( 'Recent_Post_Widget' );
}
add_action( 'widgets_init', 'register_recent_post_widget' );


## Изменяем настройки облака тегов
add_action( 'widget_tag_cloud_args' , 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args) {
	$args	['unit'] = 'px';
	$args	['smallest'] = '14';
	$args	['largest'] = '14';
	$args	['number'] = '11';
	$args	['orderby'] = 'count';
	return $args;
}

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'homepage-thumb', 65, 65, true ); // Кадрирование изображения
}

# меняем стиль многоточия в отрывках
add_filter ('excerpt_more', function($more) {
	return' ...';
});

// склоняем слова после числительных
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}

// Подключение хлебных крошек с отображением Категории (Category) и встроенным переводом
function breadcrumbs($separator = ' <span class="breadcrumbs-separator">&#8250;</span> ', $home = 'Главная') {

    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $base_url =  (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
	 $breadcrumbs = array("<a class='breadcrumbs-item' href=\"$base_url\">$home</a>");

	 $keys = array_keys($path);
	 $last = end($keys);

    foreach( $path as $x => $crumb ){
        $title = ucwords(str_replace(array('.php', '_'), Array('', ' '), $crumb));
        if ($title == 'Category'){
            $title = 'Категории';
			}
			if ($title == 'Web-design'){
				$title = 'Web Design';
			}
        if( $x != $last ){
            $breadcrumbs[] = '<a class="breadcrumbs-item" href="'.$base_url.$crumb.'">'.$title.'</a>';
        }
        else {
            $breadcrumbs[] = $title;
        }
    }

    return implode( $separator, $breadcrumbs );
}
<?php 

	//** Создаем константы путей **//

	define('NAMETHEME_HOME_DIR', get_template_directory_uri()); // Путь в корневую папку темы
	define('NAMETHEME_CSS_DIR', NAMETHEME_HOME_DIR .'/assets/css/'); // Путь в папку стилей
	define('NAMETHEME_JS_DIR', NAMETHEME_HOME_DIR .'/assets/js/'); // Путь в папку скриптов
	define('NAMETHEME_FONTS_DIR', NAMETHEME_HOME_DIR .'/assets/fonts/'); // Путь в папку шрифтов
	define('NAMETHEME_IMG_DIR', NAMETHEME_HOME_DIR .'/assets/img/'); // Путь в папку шрифтов
	// Использовать с echo

	//** Функции wordpress **//

	get_header(); // Подключает файл header.php
	get_footer();	// Подключает файл footer.php
	get_sidebar(); // Подключает файл sidebar.php
	get_template_directory_uri(); // Возвращает путь к папке темы
	get_stylesheet_uri(); // Возвращает путь к файлу style.css
	bloginfo('name'); // Возвращает имя сайта
	echo home_url(); // Возвращает адрес сайта
	add_filter( 'show_admin_bar', '__return_false' ); // Убить админ панель
	language_attributes(); // Вывести атрибут языка сайта
	the_custom_logo(); // Вывести логотип
	dynamic_sidebar(); // Вывести сайдбар панель для виджетов. В параметре указать имя зарегистрированного сайдбара
	the_permalink(); // Выводит УРЛ поста
	the_title(); // Выводит заголовок поста
	the_content(); // Выводит контент поста
	the_time(); // Выводит время(дату) публикации поста
	the_category(); // Выводит ссылки на рубрики, к которым принадлежит пост
	the_tags(); // Выводит ссылки на метки, которые относятся к посту
	the_post_thumbnail(); // Выводит html код картинки-миниатюры текущего поста
	the_excerpt(); // Выводит обрезанный контент с (...) на конце
	get_posts(); // Получает записи (посты, страницы, вложения) из базы данных по указанным критериям. Можно выбрать любые посты и отсортировать их как угодно.
	get_template_part(); // Ищет и подключает указанный файл темы. Похожа на PHP функцию include(), только не нужно указывать путь до темы
	get_post_format(); // Возвращает формат (тип) поста, например: quote, status, video, audio
	get_template_part( 'dir/post', get_post_format() ); // Подключит файл с именем типа записи, внутри которой используется. Например post-video.php

	//** Хуки wordpress **//

	wp_head(); // Обязательный хук в header.php
	wp_footer(); // Обязательный хук в footer.php
	wp_enqueue_scripts; // Хук срабатывает при подключении wordpess-ом скриптов. Принято вешать на этот хук свои скрипты и стили. Прикреплен к хуку wp-head().
	after_setup_theme // Это один из первых хуков, срабатывает прямо перед инициализацией WordPress, перед хуком init.

	//** Подключение стилей и скриптов **//

	add_action( 'wp_enqueue_scripts', 'nametheme_scripts' ); // Вызов функции после хука подключения скриптов
	function nametheme_scripts()
	{
		wp_enqueue_style( 'style', get_stylesheet_uri() ); // Подключение style.css
		wp_enqueue_style( 'mystyle', NAMETHEME_CSS_DIR . 'mystyle.css' ); // Подключение других стилей
		wp_enqueue_script( 'scripts', NAMETHEME_JS_DIR . 'scripts.js' ); // Подключение скриптов  
		// jquery регистрируется в WP по умолчанию. Но старая версия. Поэтому регистрируем свою
		wp_deregister_script( 'jquery' ); // Удаляет ранее зарегистрированный скрипт
		wp_register_script( 'jquery', NAMETHEME_JS_DIR . 'jquery-3.2.1.min.js' ); // Регистрирует новый скрипт
		wp_enqueue_script( 'jquery' ); // Подключает зарегистрированный JQuery
	};

	//** Настройки темы **//

	add_action( 'after_setup_theme', 'nametheme_setup');
	function nametheme_setup()
	{
		add_theme_support( 'title-tag' ); // Позволяет плагинам и темам изменять метатег <title>
		add_theme_support( 'custom-logo' ); // Добавляет возможность загрузить картинку логотипа в настройках темы в админке
		add_theme_support( 'post-thumbnails' ); // Позволяет устанавливать миниатюры постам
		register_nav_menu( 'top', 'Верхнее меню' ); // Регистрация области для меню
		add_theme_support( 'post-formats', array( 'aside', 'gallery' ) ); // Позволяет указывать формат постам
	};

	//** Вывод меню **//

	wp_nav_menu( [ // Выводит меню
		'theme_location'  => '', // Идентификатор расположение меню в шаблоне. Идентификатор, указывается при регистрации меню функцией register_nav_menu().
		'menu'            => '', // Меню которое нужно вывести. Соответствие: id, слаг или название меню.
		'container'       => 'div', // Чем оборачивать ul тег. Может быть: div или nav. Если не нужно оборачивать ничем, то пишем false: container => false.
		'container_class' => '', // Значение атрибута class="" у контейнера меню.
		'container_id'    => '', // Значение атрибута id="" у контейнера меню.
		'menu_class'      => 'menu', // Значение атрибута class у тега ul.
		'menu_id'         => '', // Значение атрибута id у тега ul.
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>', // Шаблон обёртки для элементов меню. Шаблон обязательно должен иметь плейсхолдер %3$s, остальное опционально.
		'before'          => '', // Текст перед тегом <a> в меню.
		'after'           => '', // Текст после каждого тега </a> в меню.
		'link_before'     => '', // Текст перед анкором каждой ссылки в меню.
		'link_after'      => '', // Текст после анкора каждой ссылки в меню.
		'echo'            => true, // Выводить на экран (true) или возвратить для обработки (false).
		'fallback_cb'     => 'wp_page_menu', // Функция для обработки вывода, если никакое меню не найдено. Передает все аргументы $args указанной тут функции. Установите пустую строку '' или '__return_empty_string', чтобы ничего не выводилось, если меню нет.
		'depth'           => 0, // До какого уровня вложенности нужно показывать ссылки (элементы меню). 0 - все уровни.
		'walker'          => '', // Класса, который будет использоваться для построения меню. Нужно указывать объект, а не строку, например new My_Menu_Walker(). По умолчанию: Walker_Nav_Menu().
	] );

	//* Регистрация сайдбара *//

	add_action( 'widgets_init', 'nametheme_widgets' );
	function nametheme_widgets(){
		register_sidebar( array(
			'name'          => sprintf(__('Sidebar %d'), $i ), // Название панели виджетов
			'id'            => "sidebar-$i", // Идентификатор виджета
			'description'   => '', // Текст описывающий где будет выводиться панель виджетов
			'class'         => '', // CSS класс, который будет добавлен главному HTML тегу панели виджетов
			'before_widget' => '<li id="%1$s" class="widget %2$s">', // HTML код, который будет расположен перед каждым виджетом в панели
			'after_widget'  => "</li>\n", // HTML код, который будет расположен после каждого виджета в панели
			'before_title'  => '<h2 class="widgettitle">', // HTML код перед заголовком виджета
			'after_title'   => "</h2>\n", // HTML код после заголовка виджета
		) );
	};

	//* Вывод постов *// 

	if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
		<!-- Вывод постов: the_title() и т.д. -->
	<?php } } else { ?>
		<p>Записей нет.</p>
	<?php }

	// *Отключаем srcset и sizes для картинок *//

	if( 'Disable srcset/sizes' ){
		add_filter( 'wp_calculate_image_srcset_meta', '__return_null' ); // Отменяем srcset
		add_filter( 'wp_calculate_image_sizes', '__return_false',  99 ); // Отменяем sizes
		add_filter( 'wp_img_tag_add_srcset_and_sizes_attr', '__return_false' ); // Удаляем фильтр, который добавляет srcset ко всем картинкам в тексте записи
	};
	add_filter( 'wp_get_attachment_image_attributes', 'unset_attach_srcset_attr', 99 ); // Очищаем атрибуты `srcset` и `sizes`, если по каким-то причинам они остались
	function unset_attach_srcset_attr( $attr ){
		foreach( array('sizes','srcset') as $key ){
			if( isset($attr[ $key ]) )
				unset($attr[ $key ]);
		}
		return $attr;
	};

	//* Отключаем width и height для картинок *//
	
	add_filter('wp_get_attachment_image_src','delete_width_height_img', 100, 4);
	function delete_width_height_img($image, $attachment_id, $size, $icon){
    $image[1] = '';
    $image[2] = '';
    return $image;
	};

	//* Изменение длины обрезаемого текста the_excerpt() *//

	add_filter( 'excerpt_length', function(){
		return 20;
	} );

	//* Создаем ссылку "Читать дальше..." на конце обрезаемого текста the_excerpt() *//

	add_filter( 'excerpt_more', 'nametheme_excerpt_more' );
	function nametheme_excerpt_more( $more ){
		global $post;
		return '<a href="'. get_permalink($post) . '"> Читать дальше...</a>';
	}

	//* удаляет H2 из шаблона пагинации *//

	add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
	function my_navigation_template( $template, $class ){
		/*
		Вид базового шаблона:
		<nav class="navigation %1$s" role="navigation">
			<h2 class="screen-reader-text">%2$s</h2>
			<div class="nav-links">%3$s</div>
		</nav>
		*/
		return '
		<nav class="navigation %1$s" role="navigation">
			<div class="nav-links">%3$s</div>
		</nav>    
		';
	};

	//* Вывод на экран пагинации на след./пред. сет постов *//

	the_posts_pagination( array(
		'show_all'     => false, // показаны все страницы участвующие в пагинации
		'end_size'     => 1,     // количество страниц на концах
		'mid_size'     => 1,     // количество страниц вокруг текущей
		'prev_next'    => true,  // выводить ли боковые ссылки "предыдущая/следующая страница".
		'prev_text'    => __('« Previous'), // текст ссылки на предыдущую страницу
		'next_text'    => __('Next »'), // текст ссылки на следующую страницу
		'add_args'     => false, // массив аргументов (переменных запроса), которые нужно добавить к ссылкам.
		'add_fragment' => '',     // текст который добавиться ко всем ссылкам.
		'screen_reader_text' => __( 'Posts navigation' ), // заголовок
	) ); 

	//* Свои action и shortcode *//

	add_action( 'my_action', 'my_function' ); // создать свое действие
	do_action( 'my_action' ) // запустить свое действие
	add_shortcode( 'my_shortcode', 'my_function' ); // создать свой шорткод
	[my_shortcode] // запустить свой шорткод. запускается из админки


?>
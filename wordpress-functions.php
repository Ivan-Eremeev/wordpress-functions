<?php 

	//** Создаем константы путей **//

	define('NAMETHEME_HOME_DIR', get_template_directory_uri()); // Путь в корневую папку темы
	define('NAMETHEME_CSS_DIR', NAMETHEME_HOME_DIR .'/assets/css/'); // Путь в папку стилей
	define('NAMETHEME_JS_DIR', NAMETHEME_HOME_DIR .'/assets/js/'); // Путь в папку скриптов
	define('NAMETHEME_FONTS_DIR', NAMETHEME_HOME_DIR .'/assets/fonts/'); // Путь в папку шрифтов
	define('NAMETHEME_IMG_DIR', NAMETHEME_HOME_DIR .'/assets/img/'); // Путь в папку изображений
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
	the_post_thumbnail_url(); // Выводит url картинки-миниатюры текущего поста
	the_excerpt(); // Выводит обрезанный контент с (...) на конце
	get_posts(); // Получает записи (посты, страницы, вложения) из базы данных по указанным критериям. Можно выбрать любые посты и отсортировать их как угодно.
	get_template_part(); // Ищет и подключает указанный файл темы. Похожа на PHP функцию include(), только не нужно указывать путь до темы
	get_post_format(); // Возвращает формат (тип) поста, например: quote, status, video, audio
	get_template_part( 'dir/post', get_post_format() ); // Подключит файл с именем типа записи, внутри которой используется. Например post-video.php
	echo get_num_queries(); // Получает количество запросов которое было сделано к базе данных WordPress до момента вызова этой фукнции
	echo do_shortcode(); // Вывести шорткод через php файл
	the_terms() // Выводит список ссылок на термины (элементы таксономии), относящиеся к указанному посту
	?>
	<p> Всего запросов к базе "<strong><?php echo get_num_queries(); ?></strong>", время загрузки "<strong><?php echo timer_stop(); ?>"</strong>".</p>
	<?php
	get_post_meta(); // Получает значение произвольного поля записи (поста).
	the_field(); // Получает значение произвольного поля записи (поста) (плагин Advanced Castom Fields).
	echo rwmb_meta(); // Получает значение произвольного поля записи (поста) (плагин MetaBox).

	//** Хуки wordpress **//

	wp_head(); // Обязательный хук в header.php
	wp_footer(); // Обязательный хук в footer.php
	wp_enqueue_scripts; // Хук срабатывает при подключении wordpess-ом скриптов. Принято вешать на этот хук свои скрипты и стили. Прикреплен к хуку wp-head().
	after_setup_theme; // Это один из первых хуков, срабатывает прямо перед инициализацией WordPress, перед хуком init.

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
		register_nav_menus( [ // Регистрации нескольких меню
			'header_menu' => 'Меню в шапке',
			'footer_menu' => 'Меню в подвале'
		] );
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
	do_action( 'my_action' ); // запустить свое действие
	add_shortcode( 'my_shortcode', 'my_function' ); // создать свой шорткод
	[my_shortcode]; // запустить свой шорткод. запускается из админки

	//* Создать новый тип записи или изменить имеющийся *//
	
	add_action( 'init', 'register_post_types' );
	function register_post_types(){
		register_post_type( 'nametheme_postname', [
			'label'  => null,
			'labels' => [
				'name'               => '____', // основное название для типа записи
				'singular_name'      => '____', // название для одной записи этого типа
				'add_new'            => 'Добавить ____', // для добавления новой записи
				'add_new_item'       => 'Добавление ____', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование ____', // для редактирования типа записи
				'new_item'           => 'Новое ____', // текст новой записи
				'view_item'          => 'Смотреть ____', // для просмотра записи этого типа.
				'search_items'       => 'Искать ____', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => '____', // название меню
			],
			'description'         => '',
			'public'              => true, // Определяет является ли тип записи публичным или нет
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			// 'show_ui'             => null, // зависит от public
			// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'        => true, // показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => null, // добавить в REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => 2, // Позиция где должно расположится меню нового типа записи
			'menu_icon'           => 'dashicons-welcome-widgets-menus', // Ссылка на картинку, которая будет использоваться для этого меню. можно поставить из пакета иконок wordpress https://developer.wordpress.org/resource/dashicons/#cover-image
			//'capability_type'   => 'post', // Строка которая будет маркером для установки прав для этого типа записи
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false, // Будут ли записи этого типа иметь древовидную структуру (как постоянные страницы)
			'supports'            => [ 'title', 'editor' ], // Вспомогательные поля на странице создания/редактирования этого типа записи 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => [], // Массив зарегистрированных таксономий, которые будут связаны с этим типом записей
			'has_archive'         => false, // Включить поддержку страниц архивов для этого типа записей
			'rewrite'             => true, // Использовать ли ЧПУ для этого типа записи
			'query_var'           => true, // Устанавливает название параметра запроса для создаваемого типа записи
		] );
	};

	//* Вывод своего типа записи *//
	$posts = get_posts( array(
		'numberposts' => 5, // Количество выводимых постов
		'post_type'   => 'nametheme_postname', //Какого типа посты нужно получать
	) );
	foreach( $posts as $post ){
		setup_postdata($post);
	?>
	    // Сюда писать код html
	<?php
	}
	wp_reset_postdata(); // сброс

	//* Добавляет (регистрирует) новую (пользовательскую) таксономию *//

	add_action( 'init', 'create_taxonomy' );
	function create_taxonomy(){

		register_taxonomy( 'nametheme_nametaxonomy', [ 'post' ], [ 
			'label'                 => '', // определяется параметром $labels->name
			'labels'                => [
				'name'              => 'Таксономия',
				'singular_name'     => 'Таксономия',
				'search_items'      => 'Найти таксономию',
				'all_items'         => 'Все таксономии',
				'view_item '        => 'Смотреть таксономию',
				'parent_item'       => 'Родительская таксономия',
				'parent_item_colon' => 'Родительская таксономия:',
				'edit_item'         => 'Изменить таксономию',
				'update_item'       => 'Обновить таксономию',
				'add_new_item'      => 'Добавиь новую таксономию',
				'new_item_name'     => 'Новое ися таксономии',
				'menu_name'         => 'Таксономия',
			],
			'description'           => '', // описание таксономии
			'public'                => true,
			// 'publicly_queryable'    => null, // равен аргументу public
			// 'show_in_nav_menus'     => true, // равен аргументу public
			// 'show_ui'               => true, // равен аргументу public
			// 'show_in_menu'          => true, // равен аргументу show_ui
			// 'show_tagcloud'         => true, // равен аргументу show_ui
			// 'show_in_quick_edit'    => null, // равен аргументу show_ui
			'hierarchical'          => false, // true - таксономия будет древовидная (как категории). false - будет не древовидная (как метки)

			'rewrite'               => true, // false - отключит перезапись
			//'query_var'             => $taxonomy, // название параметра запроса
			'capabilities'          => array(), // Массив прав для этой таксономии
			'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
			'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
			'show_in_rest'          => null, // добавить в REST API
			'rest_base'             => null, // $taxonomy
			// '_builtin'              => false,
			//'update_count_callback' => '_update_post_term_count',
		] );
	};

	## Выводит данные о кол-ве запросов к БД, время выполнения скрипта и размер затраченной памяти.
	add_action( 'admin_footer_text', 'wp_usage' ); // в подвале админки
	add_action( 'wp_footer', 'wp_usage' );         // в подвале сайта
	function wp_usage(){
		echo sprintf( '<p>Запросов к базе: "%d" за "%s" сек. "%s" MB</p>',
			get_num_queries(),
			timer_stop( 0, 3 ),
			round( memory_get_peak_usage()/1024/1024, 2 )
		);
	};

	//* Отключить обновление плагина *//
	add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
	function filter_plugin_updates( $value ) {
		unset( $value->response['advanced-custom-fields-pro-master/acf.php'] );
		return $value;
	}

	## Отключает Гутенберг (новый редактор блоков в WordPress).
	## ver: 1.2
	if( 'disable_gutenberg' ){
		remove_theme_support( 'core-block-patterns' ); // WP 5.5

		add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );

		// отключим подключение базовых css стилей для блоков
		// ВАЖНО! когда выйдут виджеты на блоках или что-то еще, эту строку нужно будет комментировать
		remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );

		// Move the Privacy Policy help notice back under the title field.
		add_action( 'admin_init', function(){
			remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
			add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
		} );
	}

	// Создать header и footer ACF
	add_action('acf/init', 'my_acf_op_init');
	function my_acf_op_init() {
		if( function_exists('acf_add_options_page') ) {

			acf_add_options_page(array(
					'page_title'    => 'Хедер',
					'menu_title'    => 'Хедер',
					'menu_slug'     => 'theme-header-settings',
					'position'			=> '4.1',
					'icon_url'			=> 'dashicons-admin-page'
			));

			acf_add_options_page(array(
					'page_title'    => 'Футер',
					'menu_title'    => 'Футер',
					'menu_slug'     => 'theme-footer-settings',
					'position'			=> '58.8',
					'icon_url'			=> 'dashicons-admin-page'
			));
			
		}
	}

	// Удалить пункты из меню админки
	add_action( 'admin_menu', 'remove_menus' );
	function remove_menus(){

		remove_menu_page( 'index.php' );                  // Консоль
		remove_menu_page( 'edit.php' );                   // Записи
		remove_menu_page( 'upload.php' );                 // Медиафайлы
		remove_menu_page( 'edit.php?post_type=page' );    // Страницы
		remove_menu_page( 'edit-comments.php' );          // Комментарии
		remove_menu_page( 'themes.php' );                 // Внешний вид
		remove_menu_page( 'plugins.php' );                // Плагины
		remove_menu_page( 'users.php' );                  // Пользователи
		remove_menu_page( 'tools.php' );                  // Инструменты
		remove_menu_page( 'options-general.php' );        // Параметры
		remove_menu_page( 'edit.php?post_type=acf-field-group' );        // Группы полей (ACF)

	}

	// Добавить пункты в меню админки
	add_action( 'admin_menu', 'register_my_page' );
	function register_my_page()
	{
		add_menu_page('Менюшки сайта', 'Менюшки сайта', 'edit_posts', 'nav-menus.php', '', 'dashicons-menu', 58.9);
	}

	// Регистрация скриптов
	add_action( 'init', 'register_scripts' );
	function register_scripts(){
		// jQuery
		wp_register_script( 'milo-jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), _S_VERSION, true );
	}

	// Добавить в админку колонку с id записи или страницы
	function true_id($args){
		$args['post_page_id'] = 'ID';
		return $args;
	}
	function true_custom($column, $id){
		if($column === 'post_page_id'){
			echo $id;
		}
	}
	add_filter('manage_pages_columns', 'true_id', 5);
	add_action('manage_pages_custom_column', 'true_custom', 5, 2);
	add_filter('manage_posts_columns', 'true_id', 5);
	add_action('manage_posts_custom_column', 'true_custom', 5, 2);

	## Удаление базовых элементов (ссылок) из тулбара
	add_action( 'add_admin_bar_menus', function(){	
		if ( ! is_network_admin() && ! is_user_admin() ) {
			// комментарии
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
			// добавить запись, страницу, медиафайл и т.д.
			remove_action( 'admin_bar_menu', 'wp_admin_bar_new_content_menu', 70 );
		}
	});

?>
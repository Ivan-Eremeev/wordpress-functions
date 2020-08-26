<?php 

	//** Задать константы путей в папки **//

	define('MY_HOME_DIR', get_template_directory_uri()); // Путь в корневую папку темы
	define('MY_CSS_DIR', LSTK_HOME_DIR .'/assets/css/'); // Путь в папку стилей
	define('MY_JS_DIR', LSTK_HOME_DIR .'/assets/js/'); // Путь в папку скриптов
	define('MY_FONTS_DIR', LSTK_HOME_DIR .'/assets/fonts/'); // Путь в папку шрифтов
	define('MY_IMG_DIR', LSTK_HOME_DIR .'/assets/img/'); // Путь в папку шрифтов

	//** Функции wordpress **//

	get_header(); // Подключает файл header.php
	get_footer();	// Подключает файл footer.php
	get_template_directory_uri() // Возвращает путь к папке темы
	get_stylesheet_uri() // Возвращает путь к файлу style.css
	bloginfo('name'); // Возвращает имя сайта
	bloginfo('url'); // Возвращает адрес сайта
	add_theme_support( 'title-tag' ); // Выводит title

	//** Хуки wordpress **//

	wp_head(); // Обязательный хук в header.php
	wp_footer(); // Обязательный хук в footer.php
	wp_enqueue_scripts; // Хук срабатывает при подключении wordpess-ом скриптов. Принято вешать на этот хук свои скрипты и стили. Прикреплен к хуку wp-head().
	after_setup_theme // Это один из первых хуков, срабатывает прямо перед инициализацией WordPress, перед хуком init.

	//** Подключение стилей и скриптов **//

	add_action( 'wp_enqueue_scripts', 'theme_add_scripts' ); // Вызов функции после хука подключения скриптов

	function theme_add_scripts()
	{
		wp_enqueue_style( 'style', get_stylesheet_uri() ); // Подключение style.css
		wp_enqueue_style( 'mystyle', LSTK_CSS_DIR . 'mystyle.css' ); // Подключение других стилей
		wp_enqueue_script( 'scripts', LSTK_JS_DIR . 'scripts.js' ); // Подключение скриптов  
		// jquery регистрируется в WP по умолчанию. Но старая версия. Поэтому регистрируем свою
		wp_deregister_script( 'jquery' ); // Удаляет ранее зарегистрированный скрипт
		wp_register_script( 'jquery', LSTK_JS_DIR . 'jquery-3.2.1.min.js' ); // Регистрирует новый скрипт
		wp_enqueue_script( 'jquery' ); // Подключает зарегистрированный JQuery

	//** Регистрация и вывод меню **//

	add_action( after_setup_theme, 'theme_register_nav_menu' );

	function theme_register_nav_menu()
	{
		register_nav_menu( 'top', 'Верхнее меню' ); // Регистрация области для меню
	}

	wp_nav_menu( [ // Выводит меню
		'theme_location'  => '', // Идентификатор расположение меню в шаблоне. Идентификатор, указывается при регистрации меню функцией register_nav_menu().
		'menu'            => '', // Меню которое нужно вывести. Соответствие: id, слаг или название меню.
		'container'       => 'div', // Чем оборачивать ul тег. Может быть: div или nav. Если не нужно оборачивать ничем, то пишем false: container => false.
		'container_class' => '', // Значение атрибута class="" у контейнера меню.
		'container_id'    => '', // Значение атрибута id="" у контейнера меню.
		'menu_class'      => 'menu', // Значение атрибута class у тега ul.
		'menu_id'         => '', // Значение атрибута id у тега ul.
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' // Шаблон обёртки для элементов меню. Шаблон обязательно должен иметь плейсхолдер %3$s, остальное опционально.
		'before'          => '' // Текст перед тегом <a> в меню.
		'after'           => '' // Текст после каждого тега </a> в меню.
		'link_before'     => '' // Текст перед анкором каждой ссылки в меню.
		'link_after'      => '' // Текст после анкора каждой ссылки в меню.
		'echo'            => true, // Выводить на экран (true) или возвратить для обработки (false).
		'fallback_cb'     => 'wp_page_menu', // Функция для обработки вывода, если никакое меню не найдено. Передает все аргументы $args указанной тут функции. Установите пустую строку '' или '__return_empty_string', чтобы ничего не выводилось, если меню нет.
		'depth'           => 0, // До какого уровня вложенности нужно показывать ссылки (элементы меню). 0 - все уровни.
		'walker'          => '', // Класса, который будет использоваться для построения меню. Нужно указывать объект, а не строку, например new My_Menu_Walker(). По умолчанию: Walker_Nav_Menu().
	] ); 

?>
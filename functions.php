<?php
/**
 * Upway functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Upway
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function upway_setup()
{
    /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on Upway, use a find and replace
        * to change 'upway' to the name of your theme in all the template files.
        */
    load_theme_textdomain('upway', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
    add_theme_support('title-tag');

    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
    add_theme_support('post-thumbnails');


 /*{{%10_06_01-12-40}}
 * primary - Создание навигации
 */
    // This theme uses wp_nav_menu() in one location.

    register_nav_menus(
        array(
            'menu-header' => esc_html__('Header Navigation', 'upway'),
            'menu-footer' => esc_html__('Footer Navigation', 'upway'),
        )
    );

    /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'upway_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}

add_action('after_setup_theme', 'upway_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function upway_content_width()
{
    $GLOBALS['content_width'] = apply_filters('upway_content_width', 640);
}

add_action('after_setup_theme', 'upway_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function upway_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'upway'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'upway'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

add_action('widgets_init', 'upway_widgets_init');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

// --------------  Наш код ниже  ----------------------------------------------------

/**
 * Enqueue scripts and styles.
 */

function upway_scripts()
{
//    --------------------------  Подключение CSS  -------------------------


    wp_enqueue_style('upway-style', get_stylesheet_uri());
    //    Подкл, css 1-ID, 2 - путь к файлу, 3-зависимости, 4-версия,5-атрибут медиа
    wp_enqueue_style('upway-main', get_template_directory_uri() . '/assets/css/main.min.css', array(), '1.0');
    wp_enqueue_style('upway-vendor', get_template_directory_uri() . '/assets/css/vendor.min.css', array(), '1.0');

    wp_style_add_data('upway-style', 'rtl', 'replace');

//    ------------------------------- Подключение JS  _______________________________
    wp_enqueue_script('jquery3.1.1', "http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
    wp_enqueue_script('goodshare', "https://cdn.jsdelivr.net/npm/goodshare.js@4/goodshare.min.js", array(), '', true);

    wp_enqueue_script('upway-vendor', get_template_directory_uri() . '/assets/js/vendor.min.js', array(), '1.0', true);

    wp_enqueue_script('upway-common', get_template_directory_uri() . '/assets/js/common.min.js', array(), '1.0', true);

    wp_enqueue_script('upway-svg-sprite', get_template_directory_uri() . '/assets/img/svg-sprite/svg-sprite.js', array(), '1.0', false);


//--------------------  для подгрузки комментов  ---------------------------------------------
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'upway_scripts');

/*
 *-------------------Класс на body для специфической страницы{{%10_06_51-56}}--------------
 */
add_filter('body_class', 'upway_body_class');
function upway_body_class($classes)
{
    if (is_page_template('template-home.php')) {
        $classes[] = 'is-home';
    } else {
        $classes[] = 'inner-page';
    }
    return $classes;
}



















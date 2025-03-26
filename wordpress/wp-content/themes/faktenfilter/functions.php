<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 * @package WordPress
 * @subpackage Timber
 * @since Timber 0.1
 */

function theme_setup() {
    // Activer la prise en charge des balises <title>
    add_theme_support('title-tag');
  
    // Activer les images mises en avant
    add_theme_support('post-thumbnails');
  
    // Activer la prise en charge des menus -> si nécessaire
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'textdomain'),
    ));
  
    // Activer la prise en charge des styles pour l'éditeur de blocs
    add_theme_support('wp-block-styles');
  
    // Ajouter la prise en charge de l'alignement pleine largeur -> si nécessaire
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'theme_setup');

// Fonts
function my_custom_fonts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Quicksand:wght@300..700&display=swap');
}
add_action('wp_enqueue_scripts', 'my_custom_fonts');

// Load Composer dependencies.
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/StarterSite.php';

Timber\Timber::init();

function my_theme_enqueue_styles() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2', 'all');

    // Enqueue Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js', array('jquery'), '4.5.2', true);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

add_shortcode('teaser_block', function($atts) {
    $context = Timber::context();

    // Optional: Shortcode attributes
    $atts = shortcode_atts([
        'posts_per_page' => 5,
        'post_type' => 'post'
    ], $atts);

    // Query posts
    $context['posts'] = Timber::get_posts([
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page']
    ]);

    // Render your Twig file
    return Timber::compile('views/partial/teaser.twig', $context);
});

function mytheme_enqueue_styles() {
    // Your main stylesheet
    wp_enqueue_style('mytheme-styles', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');

function remove_auto_read_more( $excerpt ) {
    $excerpt = preg_replace('/<a.*?class="more-link".*?>.*?<\/a>/i', '', $excerpt);
    return $excerpt;
}
add_filter( 'get_the_excerpt', 'remove_auto_read_more' );

// Sets the directories (inside your theme) to find .twig files.
// Timber::$dirname = [ 'templates', 'views' ];

// Example of adding custom CSS
// function add_styles() {
//     wp_enqueue_style( 'fontawesome-style', get_theme_file_uri( '/assets/css/all.css' ), array(), null );
// }
// add_action( 'wp_enqueue_scripts', 'add_styles' );

// Function to set the background image in header.twig
function add_header_background_image($context) {
    // Get the background image URL
    $context['background_image'] = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Use 'full' size or another preferred size
    return $context;
}

// Update your Timber rendering logic
function render_header_with_background() {
    $context = Timber::context(); // Using context() instead of get_context()
    $context = add_header_background_image($context); // Add the background image URL to the context
    Timber::render('header.twig', $context);
}

// Call the header rendering function
render_header_with_background();

// Header rendering is now managed through the render_header_with_background function.



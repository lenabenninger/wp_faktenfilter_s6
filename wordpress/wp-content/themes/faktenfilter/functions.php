<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 * @package WordPress
 * @subpackage Timber
 * @since Timber 0.1
 */

//  add_shortcode('teaser_block', function($atts) {
//     $context = Timber::context();
//     ob_start();
//     Timber::render('partial/teaser.twig', $context);
//     return ob_get_clean();
// });



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


  //Fonts
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

    // Example for custom teaser CSS if separate
    // wp_enqueue_style('teaser-styles', get_template_directory_uri() . '/assets/css/teaser.css');
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');

function remove_auto_read_more( $excerpt ) {
    $excerpt = preg_replace('/<a.*?class="more-link".*?>.*?<\/a>/i', '', $excerpt);
    return $excerpt;
}
add_filter( 'get_the_excerpt', 'remove_auto_read_more' );





// Sets the directories (inside your theme) to find .twig files.
// Timber::$dirname = [ 'templates', 'views' ];

// function add_styles() {
//     wp_enqueue_style( 'fontawesome-style', get_theme_file_uri( '/assets/css/all.css' ), array(), null );
// }
// add_action( 'wp_enqueue_scripts', 'add_styles' );

// new StarterSite();

// $composer_autoload = __DIR__ . '/vendor/autoload.php'; // Make sure __DIR has a trailing slash.
// if ( file_exists( $composer_autoload ) ) {
//     require_once $composer_autoload;
//     $timber = new Timber\Timber();
// }

// if ( ! class_exists( 'Timber' ) ) {
//     add_action(
//         'admin_notices',
//         function() {
//             echo '<div class="error"><p>Timber is not activated. Make sure you activate the plugin.</p></div>';
//         }
//     );
// }


//select faktenfilter to write leserbrief about

function display_posts_radio_buttons($atts) {
    // Set up defaults
    $atts = shortcode_atts([
        'category' => 'Allgemein', // Category name to filter by
    ], $atts);

    // Query for all posts in the "Allgemein" category
    $args = [
        'category_name' => $atts['category'], // Filter by category slug
        'posts_per_page' => -1, // Set to -1 to get all posts
    ];
    $posts = get_posts($args);

    // Check if posts exist
    if (empty($posts)) {
        return '<p>No posts found in the "Allgemein" category.</p>';
    }

    // Start the output for both list and radio buttons
    $output = '<ul>';
    foreach ($posts as $post) {
        // Generate the list item with a radio button
        $post_id = esc_attr($post->ID);
        $output .= '<li>';
        $output .= '<input type="radio" id="post-' . $post_id . '" name="selected_post" value="' . $post_id . '" class="select-post-circle">';
        $output .= '<label for="post-' . $post_id . '" class="select-post">';
        $output .= esc_html($post->post_title);
        $output .= '</label>';
        $output .= '</li>';
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('posts_radio_buttons', 'display_posts_radio_buttons');

//categories for pages to group them in menu
function create_page_category_taxonomy() {
    // Register custom taxonomy for pages
    register_taxonomy(
        'page_category', // Taxonomy name
        'page', // Apply to pages
        array(
            'label' => __('Page Categories'),
            'rewrite' => array('slug' => 'page-category'),
            'hierarchical' => true, // Optional: Create parent-child categories
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true, // Enable for Gutenberg
        )
    );
}
add_action('init', 'create_page_category_taxonomy');

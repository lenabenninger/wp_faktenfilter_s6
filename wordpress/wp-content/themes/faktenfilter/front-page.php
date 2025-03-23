<?php
$context = Timber::context();

// Get 3 posts from "allgemein"
$context['allgemein_posts'] = Timber::get_posts([
    'posts_per_page' => 3,
    'category_name'  => 'allgemein',
]);

// Get 1 post from "empfehlung"
$context['empfehlung_post'] = Timber::get_posts([
    'posts_per_page' => 1,
    'category_name'  => 'empfehlung',
]);

Timber::render('front-page.twig', $context);
?>


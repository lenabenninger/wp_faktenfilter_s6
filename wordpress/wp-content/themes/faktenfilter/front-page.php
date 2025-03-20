<?php
$context = Timber::context();
$context['posts'] = Timber::get_posts(
    [ 'posts_per_page' => 3,]
);
Timber::render('front-page.twig', $context);
?>

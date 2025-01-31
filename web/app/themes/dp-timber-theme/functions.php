<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 */

use Timber\Timber;

require_once __DIR__ . '/src/StarterSite.php';

Timber::init();

// Sets the directories (inside your theme) to find .twig files.
Timber::$dirname = ['templates', 'views'];

function add_custom_twig_filters($twig)
{
    $twig->addFilter(new \Twig\TwigFilter('space_between_letters', function ($string) {
        return implode(' ', str_split($string));
    }));

    $twig->addFilter(new \Twig\TwigFilter('reverse', function ($string) {
        return strrev($string);
    }));

    $twig->addFilter(new \Twig\TwigFilter('remove_alternate_words', function ($string) {
        $words = explode(' ', $string);
        foreach ($words as $index => $word) {
            if ($index % 2 != 0) {
                $words[$index] = ' ';
            }
        }
        return implode(' ', $words);
    }));

    return $twig;
}

// Register custom post type 'movie'
function custom_register_movie_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Movies',
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
    );
    register_post_type( 'movie', $args );
}

add_action( 'init', 'custom_register_movie_post_type' );
add_filter('timber/twig', 'add_custom_twig_filters');

new StarterSite();

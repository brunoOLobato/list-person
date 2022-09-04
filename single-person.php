<?php

/**
 * Single page for cases
 */

get_header();


if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('single')) {

    if (Elementor\Plugin::instance()->documents->get(get_the_ID())->is_built_with_elementor()) {
        the_content();
    } else {
        echo '<section id="singleEngine" class=""><div class="container">';
        echo do_shortcode('[caseInfos]');
        the_content();
        echo '</div></section>';
    }
}

get_footer();

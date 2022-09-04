<?php

/**
 * Single page for cases
 */

get_header();
echo '<section id="pag-list-person"><div class="container">';

echo '<div class="person-list-box"><div class="box">';
echo '<div class="list-person">';

echo '<div class="item" data-id="' . get_the_ID() . '">';
echo '<div class="icon">';
echo get_post_meta(get_the_ID(), 'personicon', true);
echo '</div>';
echo '<div class="text"><h2>' . get_the_title() . '</h2>';
echo '<a href="mailto:' . get_post_meta(get_the_ID(), 'personmail', true) . '">' . get_post_meta(get_the_ID(), 'personmail', true) . '</a>';
echo '<span>' . get_post_meta(get_the_ID(), 'personphonecode', true);
echo ' ' . get_post_meta(get_the_ID(), 'personphone', true) . '</span></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div></section>';
get_footer();

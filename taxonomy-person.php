<?php

/**
 * Tax page for person
 */

get_header();


echo '<section id="pag-list-person"><div class="container">';
echo do_shortcode('[personList]');
echo '</div></section>';

get_footer();

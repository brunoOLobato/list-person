<?php

/**
 * @package  PersonPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseControllerPerson;

global $wp_roles;

/**
 * 
 */
class PersonCTP extends BaseControllerPerson
{

    /**
     * Register actions and filter of custom posts types
     */
    public function register()
    {
        add_action('init', array($this, 'custom_post')); // register a new costom post type
        add_action('admin_init', array($this, 'add_person_delete_cap')); // register capabilities do users
        add_filter('enter_title_here', array($this, 'change_title_text'));

        add_action('add_meta_boxes', array($this, 'meta_boxes'));
        add_action('save_post', array($this, 'save_post_data'));
        add_filter('single_template', array($this, 'custom_template_person'));
        add_filter('archive_template', array($this, 'taxonomy_template'));

        add_action('wp_ajax_getSubcat', array($this, 'getSubcat'));
        add_action('wp_ajax_nopriv_getSubcat', array($this, 'getSubcat'));

        add_action('wp_ajax_getPostsfilter', array($this, 'getPostsfilter'));
        add_action('wp_ajax_nopriv_getPostsfilter', array($this, 'getPostsfilter'));


        // add_shortcode('caseInfos', array($this, 'caseInfos'));
        add_shortcode('personList', array($this, 'personList'));

        //add_action('after_setup_theme', array($this, 'menu_case_list_register'));
    }

    /*public function menu_case_list_register()
    {
        register_nav_menus(
            array(
                'menuCaseList' => __('Menu Case List'),
            )
        );
    }*/

    function change_title_text($title)
    {
        $screen = get_current_screen();

        if ('person' == $screen->post_type) {
            $title = 'Person name';
        }

        return $title;
    }




    /**
     * Register all custom post types used by plugins 
     */
    public function custom_post()
    {

        register_post_type(
            'person',
            array(
                'labels'      => array(
                    'name'          => __('Person'),
                    'singular_name' => __('Person'),

                    'add_new'               => __('Add Person'),
                    'add_new_item'          => __('Add New Person'),
                    'new_item'              => __('New Person'),
                    'edit_item'             => __('Edit Person'),
                    'view_item'             => __('View Person'),
                    'all_items'             => __('All Person'),
                ),
                "description" => "",
                "menu_position" => 5,
                'public'      => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "rest_namespace" => "wp/v2",

                'has_archive' => true,
                "show_in_menu" => true,
                'show_in_nav_menus' => true,
                "delete_with_user" => false,
                'exclude_from_search' => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "query_var" => true,
                "can_export" => false,
                // 'rewrite'     => ["slug" => "person", "with_front" => true],
                "menu_icon"     => "dashicons-admin-users",
                "supports"      => [
                    "title",
                ],
                "show_in_graphql" => false,
            )
        );

        flush_rewrite_rules(false);
    }


    /**
     * Add capabilities do users 
     */
    function add_person_delete_cap()
    {
        // Add the roles you'd like to administer the custom post types
        $roles = array('editor', 'administrator');

        // Loop through each role and assign capabilities
        foreach ($roles as $the_role) {
            $role = get_role($the_role);
            $role->add_cap('edit_person');
            $role->add_cap('read_person');
            $role->add_cap('delete_person');
            $role->add_cap('edit_person');
            $role->add_cap('edit_others_person');
            $role->add_cap('publish_person');
            $role->add_cap('read_private_person');
            $role->add_cap('edit_person');
            $role->add_cap('delete_published_person');
        }
    }


    /**
     * Create a metaboxes to post types 
     */
    public function meta_boxes()
    {
        add_meta_box(
            'general',
            'User information',
            array($this, 'general_metabox'),
            'person'
        );
    }
    function general_metabox($post)
    {
        $restcountries = file_get_contents('https://restcountries.com/v3.1/all');
        $restcountriesj = json_decode($restcountries, true);
        usort($restcountriesj, function ($a, $b) {
            return strcmp($a['name']['common'], $b['name']['common']);
        });

        $pixelencounter = file_get_contents('https://app.pixelencounter.com/api/basic/monsters/random');

        $personmail                = get_post_meta($post->ID, 'personmail', true);
        $personphonecode           = get_post_meta($post->ID, 'personphonecode', true);
        $personphone               = get_post_meta($post->ID, 'personphone', true);
        $personicon                = get_post_meta($post->ID, 'personicon', true) ? get_post_meta($post->ID, 'personicon', true) : $pixelencounter;

        echo "<div id='wrap'>";

        echo '<pre>';
        //var_dump($restcountriesj);
        echo '</pre>';

        /**
         * Field
         */
        echo "<label class='label-metabox' for='personmail'>E-mail</label>";
        echo '<input id="personmail" name="personmail" class="metabox-input" placeholder="E-mail" value="' . $personmail . '" type="text" />';

        echo "<label class='label-metabox' for='personphonecode'>Phone code</label>";
        echo '<select id="personphonecode" name="personphonecode" class="metabox-input">';
        foreach ($restcountriesj as $item) {
            $name = $item['name']['common'] . ' (' . $item['idd']['root'] .  $item['idd']['suffixes'][0] . ')';
            $act = $personphonecode == $value ? 'selected' : '';
            echo '<option value="' . $name . '" ' . $act . '>';
            echo $name;
            echo '</option>';
        }
        echo '</select>';

        /**
         * Field
         */
        echo "<label class='label-metabox' for='personphone'>Telephone</label>";
        echo '<input id="personphone" name="personphone" class="metabox-input" placeholder="Telephone" value="' . $personphone . '" type="text" />';

        /**
         * Field
         */
        echo "<label class='label-metabox' for='personicon'>Icon</label>";
        echo '<textarea id="personicon" name="personicon" class="metabox-input" hidden>';
        echo $personicon;
        echo '</textarea>';
        echo '<div style="width: 50px">';
        echo $personicon;
        echo "</div>";

        echo "</div>";
    }


    /**
     * When save post 
     */
    function save_post_data($post_id)
    {
        // Check the logged in user has permission to edit this post
        if (!current_user_can('manage_options')) {
            return $post_id;
        }

        if (isset($_POST['personmail'])) {
            update_post_meta($post_id, 'personmail', $_POST['personmail']);
        }
        if (isset($_POST['personphonecode'])) {
            update_post_meta($post_id, 'personphonecode', $_POST['personphonecode']);
        }
        if (isset($_POST['personphone'])) {
            update_post_meta($post_id, 'personphone', $_POST['personphone']);
        }
        if (isset($_POST['personicon'])) {
            update_post_meta($post_id, 'personicon', $_POST['personicon']);
        }
    }

    //    /**
    //      * Template for CTP's
    //      */
    function custom_template_person($single)
    {
        global $post;
        //var_dump($post);
        $user = wp_get_current_user();
        if ($post->post_type == "person") {
            return $this->plugin_path . '/single-person.php';
        }
        return $single;
    }

    function taxonomy_template($template)
    {

        if (is_post_type_archive('person')) {
            $template = $this->plugin_path . '/taxonomy-person.php';
        }

        return $template;
    }

    function personList()
    {


        ob_start();

        echo '<div class="person-list-box"><div class="box"><h1>' .  __('person <b>list</b>') . '</h1>';
        $args = array(
            'post_type' => 'person',
            'posts_per_page' => -1
        );
        $loop = new \WP_Query($args);
        if ($loop->have_posts()) {
            echo '<div class="list-person">';
            while ($loop->have_posts()) : $loop->the_post();
                echo '<div class="item" data-id="' . get_the_ID() . '">';
                echo '<div class="icon">';
                echo get_post_meta(get_the_ID(), 'personicon', true);
                echo '</div>';
                echo '<div class="text"><h2>' . get_the_title() . '</h2>';
                echo '<a href="mailto:' . get_post_meta(get_the_ID(), 'personmail', true) . '">' . get_post_meta(get_the_ID(), 'personmail', true) . '</a>';
                echo '<span>' . get_post_meta(get_the_ID(), 'personphonecode', true);
                echo ' ' . get_post_meta(get_the_ID(), 'personphone', true) . '</span></div>';
                echo '</div>';
            endwhile;
            echo '</div>';
        }

        echo '</div></div>';

        wp_reset_postdata();
        return ob_get_clean();
    }
}

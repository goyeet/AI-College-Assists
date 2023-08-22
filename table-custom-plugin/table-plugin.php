<?php
/*
* Plugin Name: GIG Table Plugin
* Plugin URI: https://dev-ai-college-assists.pantheonsite.io/
* Description: Contains calls to create custom prompt and CV input tables and display them
* Version: 0.1
* Author: Gordon and Clarissa
* Author URI: https://dev-ai-college-assists.pantheonsite.io/
**/

include('table-data.php');

function enqueue_custom_scripts() {
    wp_enqueue_script('gig-custom-script', str_replace("code/", "", plugin_dir_path(__FILE__)) . '/js/custom-script.js', array('jquery'), '1.0', true);
    wp_localize_script('gig-custom-script', 'my_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

/** Prompt Table */

// Shortcode that formats data into prompt table
function prompt_table_shortcode() {

    $gig_user_id = get_option('gig_user_id');
    $gig_user_key = get_option('gig_user_key');

    $table_data = get_prompt_table_data();

    ob_start();
    include('prompt-table.php');
    return ob_get_clean();
}
add_shortcode('prompt_table', 'prompt_table_shortcode');

/** CV Table */

// Shortcode that formats data into cv input table
function cv_table_shortcode() {

    $gig_user_id = get_option('gig_user_id');
    $gig_user_key = get_option('gig_user_key');

    $cv_form_entry_fields_data = get_cv_form_entry_fields_data(); // get all data from cv form entries

    ob_start();
    include('cv-table.php');
    return ob_get_clean();
}
add_shortcode('cv_table', 'cv_table_shortcode');

?>
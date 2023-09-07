<?php
/*
* Plugin Name: GIG Essay Writer Plugin
* Description: Contains API calls and tables related to GIG's College Essay Writer
* Version: 0.1
* Author: Gordon and Clarissa
**/

include('gig-functions.php');

function enqueue_custom_scripts() {
    // Plugin JS File
    wp_enqueue_script('gig-custom-script', str_replace("code/", "", plugin_dir_path(__FILE__)) . '/js/custom-script.js', array('jquery'), '1.0', true);
    // Plugin AJAX File
    wp_localize_script('gig-custom-script', 'my_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
    // Plugin CSS File
    wp_enqueue_style('plugin-styles', str_replace("code/", "", plugin_dir_path(__FILE__)) . 'style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

/* Custom plugin settings page */
// Register the plugin settings
function gig_register_settings() {
    add_option( 'gig_user_key', '' ); // Initialize the option with an empty value
    register_setting( 'gig_settings', 'gig_user_key' );
	add_option( 'gig_user_id', '' ); // Initialize the option with an empty value
    register_setting( 'gig_settings', 'gig_user_id' );
}
add_action( 'admin_init', 'gig_register_settings' );

// Add the plugin settings menu
function gig_add_settings_page() {
    add_options_page( 'GIG Settings', 'GIG', 'manage_options', 'gig_settings', 'gig_settings_page' );
}
add_action( 'admin_menu', 'gig_add_settings_page' );

// Render the plugin settings page
function gig_settings_page() {
    ?>
    <div class="wrap">
        <h2>GIG Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'gig_settings' ); ?>
            <?php do_settings_sections( 'gig_settings' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">User ID</th>
                    <td>
                        <input type="text" name="gig_user_id" value="<?php echo esc_attr( get_option( 'gig_user_id' ) ); ?>" />
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row">User Key</th>
                    <td>
                        <input type="text" name="gig_user_key" value="<?php echo esc_attr( get_option( 'gig_user_key' ) ); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/** Prompt Table */
// Shortcode that formats data into prompt table
function prompt_table_shortcode() {

    ob_start();
    include('prompt-table.php');
    return ob_get_clean();
}
add_shortcode('prompt_table', 'prompt_table_shortcode');

/** CV Table */
// Shortcode that formats data into cv input table
function cv_table_shortcode() {

    ob_start();
    include('cv-table.php');
    return ob_get_clean();
}
add_shortcode('cv_table', 'cv_table_shortcode');

/** User History Table */
// Shortcode that formats data into user history table
function user_history_table_shortcode() {

    ob_start();
    include('user-history-table.php');
    return ob_get_clean();
}
add_shortcode('user_history_table', 'user_history_table_shortcode');

?>
<?php
/**
* Plugin Name: test-plugin
* Plugin URI: https://dev-ai-college-assists.pantheonsite.io/
* Description: Test.
* Version: 0.1
* Author: Gordon and Clarissa
* Author URI: https://dev-ai-college-assists.pantheonsite.io/
**/

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

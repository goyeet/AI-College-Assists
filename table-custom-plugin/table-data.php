<?php

include('ajax.php');
// print_r('file path: ' . plugin_dir_path(__FILE__) . '../api-custom-plugin/ajax.php');

// Prompt Table -----------------------------------------------

// Function to create custom table on plugin activation
// function plugin_create_user_history_table() { //creates a table for storing previous prompts and essays generated
//     global $wpdb;
//     $tabletwo_name = $wpdb->prefix . 'user_history'; // This will automatically add the WP prefix to your table name for security.

//     // Check if the table already exists
//     if ($wpdb->get_var("SHOW TABLES LIKE '$tabletwo_name'") != $tabletwo_name) {
//         $charset = $wpdb->get_charset_collate();
//         // SQL query to create the table
//         $sql = "CREATE TABLE ".$tabletwo_name." (
//             generation_id INT(10) NOT NULL AUTO_INCREMENT,
            
//             returned_response VARCHAR(650) NOT NULL,
//             PRIMARY KEY (generation_id)
//         ) $charset;";

//         // Include the upgrade script
//         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

//         // Execute the query and create the table
//         dbDelta($sql);
//     }
// }
// register_activation_hook(__FILE__, 'plugin_create_user_history_table');

// Gets data from user_history table
function get_user_history_table_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_history';
    $query = "SELECT `id`, date_time, prompt_id, prompt_type, `user_id`, response_essay, prompt FROM $table_name";
    return $wpdb->get_results($query, ARRAY_A);
}

// Stores generation results in user_history table
function set_user_history_table_data($prompt, $promptId, $promptType, $generatedResponse, $cvInput, $isCustom) {
    $return = array(
        'prompt'   => $prompt,
        'promptID' => $promptId,
        'promptType' => $promptType,
        'generatedResponse' => $generatedResponse,
        'cvInput' => $cvInput,
        'isCustom' => $isCustom,
    );
    wp_send_json($return);
    // if prompt is custom, store that custom prompt in wp_prompts data table
    // else prompt is one of the sample ones
}

// Function to create custom table on plugin activation
function plugin_create_prompt_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'prompts'; // This will automatically add the WP prefix to your table name for security.

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset = $wpdb->get_charset_collate();
        // SQL query to create the table
        $sql = "CREATE TABLE ".$table_name." (
            prompt_id INT(11) NOT NULL AUTO_INCREMENT,
            prompt_type VARCHAR(255) NOT NULL,
            prompt VARCHAR(400) NOT NULL,
            PRIMARY KEY (prompt_id)
        ) $charset;";

        // Include the upgrade script
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Execute the query and create the table
        dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'plugin_create_prompt_table');

// Gets data from prompt table
function get_prompt_table_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'prompts';
    $query = "SELECT prompt_id, prompt_type, prompt FROM $table_name";
    return $wpdb->get_results($query, ARRAY_A);
}

// CV Table ------------------------------------------------------

// Gets data from wpforms_entry_fields table
function get_cv_form_entry_fields_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpforms_entry_fields';
    $query = "SELECT `id`, entry_id, form_id, field_id, `value`, `date` FROM $table_name";
    return $wpdb->get_results($query, ARRAY_A);
}

// Gets data from wpforms_entries table
function get_cv_form_entries_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpforms_entries';
    $query = "SELECT entry_id, form_id, `user_id` FROM $table_name";
    return $wpdb->get_results($query, ARRAY_A);
}

?>
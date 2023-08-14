<?php

// Prompt Table -----------------------------------------------

// Function to create custom table on plugin activation
function plugin_create_prompt_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'prompts'; // This will automatically add the WP prefix to your table name for security.

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset = $wpdb->get_charset_collate();
        // SQL query to create the table
        $sql = "CREATE TABLE ".$table_name." (
            prompt_id INT(23) NOT NULL AUTO_INCREMENT,
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
<?php

include('ajax.php');

// print_r('file path: ' . plugin_dir_path(__FILE__) . '../api-custom-plugin/ajax.php');

// Prompt Table -----------------------------------------------

// Function to create custom table on plugin activation
function plugin_create_user_history_table() { //creates a table for storing previous prompts and essays generated
    global $wpdb;
    $table_name = $wpdb->prefix . 'gig_user_history'; // This will automatically add the WP prefix to your table name for security.

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset = $wpdb->get_charset_collate();
        // SQL query to create the table
        $sql = "CREATE TABLE ".$table_name." (
            id INT(10) NOT NULL AUTO_INCREMENT,
            user_id BIGINT(20) NOT NULL,
            prompt_id INT(11),
            custom_prompt VARCHAR(500),
            cv_inputs TEXT NOT NULL,
            generated_response TEXT NOT NULL,
            created DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset;";

        // Include the upgrade script
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Execute the query and create the table
        dbDelta($sql);
    }
}
register_activation_hook(__DIR__.'/table-plugin.php', 'plugin_create_user_history_table');

// Gets data from user_history table
function get_user_history_table_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'gig_user_history';
    $query = "SELECT `id`, date_time, prompt_id, prompt_type, `user_id`, response_essay, prompt FROM $table_name";
    return $wpdb->get_results($query, ARRAY_A);
}

// Stores generation results in user_history table
function set_user_history_table_data($promptId, $custom_prompt, $cvInput, $generatedResponse) {
    
    // print_r($generated_response);

    // TODO: sql INSERT data
    global $wpdb;

    // $table_name = $wpdb->prefix . 'gig_user_history'; // Prefix your table name with the WordPress database prefix
    
    // $data_array = array(
    //     //id auto increments
    //    // 'user_id' => get_current_user_id(),
    //     'prompt_id' => $promptId,
    //     'custom_prompt' => $custom_prompt,
    //     'cv_inputs' => $cvInput,
    //     'generated_response' => $generatedReponse,
    //   //  'created' => date("Y-m-d H:i:s")
    // );
    
    // $result = $wpdb->insert($table_name, $data_array);
    
    // (condition) ? (logic if true) : (logic if false)
    $data_array = array(
        //'Status'  => 'success',//$result ?  : false, // return success or failure
        'user_id' => get_current_user_id(),
        'prompt_id' => $promptId,
        'custom_prompt' => $custom_prompt,
        'cv_inputs' => $cvInput,
        'generated_response' => $generatedResponse
    );
    
    $result = $wpdb->insert('wp_gig_user_history', $data_array);
   
    $return = $data_array;//json_encode($data_array);
    
    
    wp_send_json($return);
}

// Function to create custom table on plugin activation
function plugin_create_prompt_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'gig_prompts'; // This will automatically add the WP prefix to your table name for security.

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        // $charset = $wpdb->get_charset_collate();
        // SQL query to create the table
        $sql = "CREATE TABLE ".$table_name." (
            prompt_id INT(11) NOT NULL AUTO_INCREMENT,
            prompt_type VARCHAR(255) NOT NULL,
            prompt VARCHAR(400) NOT NULL,
            PRIMARY KEY (prompt_id)
        )";

        // Include the upgrade script
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Store the current error setting
        $previous_errors = $wpdb->show_errors();

        // Enable error reporting
        $wpdb->show_errors();

        // Attempt to create the table
        $result = dbDelta($sql);

        // Restore the previous error setting
        $wpdb->hide_errors();

        if ($result === false) {
            // An error occurred during table creation
            wp_die("Error creating table: " . $wpdb->last_error);
        }

        // Execute the query and create the table
        
    }
}
register_activation_hook(__DIR__.'/table-plugin.php', 'plugin_create_prompt_table');

// Gets data from prompt table
function get_prompt_table_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'gig_prompts';
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
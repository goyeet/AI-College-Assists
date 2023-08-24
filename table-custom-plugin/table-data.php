<?php

include('ajax.php');

// Prompt Table -----------------------------------------------

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

        // Execute the query and create the table
        dbDelta($sql);
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

// Gets data from wp_gf_entry that has a created_by value matching logged in user_id AND
// Return: array contains all entry_id's that belong to logged in user
function get_user_cv_form_entries() {

    // $current_user_id = get_current_user_id();
    $current_user_id = 5;

    global $wpdb;
    $table_name = $wpdb->prefix . 'gf_entry';
    $query = "SELECT `id`, form_id, created_by
              FROM $table_name
              WHERE created_by = '$current_user_id' AND form_id = 1";

    $result = $wpdb->get_results($query, ARRAY_A);

    $user_entry_ids = array();
    
    // Add entry IDs to array
    if ($result) {
        foreach ($result as $row) {
            array_push($user_entry_ids, $row['id']);
        }
    } else {
        echo "No results found.";
    }

    return $user_entry_ids;
}

// Gets data from wp_gf_entry_meta that has an entry_id matching id (PRIMARY KEY) of gf_entry
// Return: Table data with rows matching entry ID
function get_user_cv_form_entry_fields($entryIDs) {
    // turn array into comma separated list to be used in SQL query
    $id_list = "'" . implode("','", $entryIDs) . "'";

    global $wpdb;
    $table_name = $wpdb->prefix . 'gf_entry_meta';
    $query = "SELECT `id`, form_id, entry_id, meta_key, meta_value
              FROM $table_name
              WHERE entry_id IN ($id_list)";

    return $wpdb->get_results($query, ARRAY_A);
}

// Takes in form id and returns display meta for corresponding form
function get_cv_form_data($form_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'gf_form_meta';
    $query = "SELECT display_meta
              FROM $table_name
              WHERE form_id = $form_id";

    return $wpdb->get_results($query, ARRAY_A);
}

function searchMultidimensionalArray($array, $searchKey, $searchValue, $returnKey) {
    foreach ($array as $subArray) {
        if (isset($subArray[$searchKey]) && (string) $subArray[$searchKey] === (string) $searchValue) {
            if (isset($subArray[$returnKey])) {
                return $subArray[$returnKey];
            }
        }
    }
    return null; // Return null if the key/value pair is not found
}

// User History Table -------------------------------------------------

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

    global $wpdb;

    $data = array(
        'user_id' => get_current_user_id(),
        'prompt_id' => $promptId,
        'custom_prompt' => $custom_prompt,
        'cv_inputs' => $cvInput,
        'generated_response' => $generatedResponse
    );
    
    $result = $wpdb->insert('wp_gig_user_history', $data);
   
    $return = array(
        'Execution' => $result ? 'Success' : 'Failure'
    );
    
    wp_send_json($return);
}

?>
<?php

include('ajax.php');

// User Meta (Tokens) -----------------------------------------

/* function initialize_existing_users_counters() {
    $user_ids = get_users(array('fields' => 'ID'));
    foreach ($user_ids as $user_id) {
        $existing_value = get_user_meta($user_id, 'user_credits_used', true);
        
        // Only initialize the counter if it's not set for this user
        if (empty($existing_value)) {
            $result = update_user_meta($user_id, 'user_credits_used', 0);
            $result ? print_r('Row added') : print_r('Row add failed');
            
        }
    }
} */

function initialize_user_counter() {
    $current_user_id = get_current_user_id();
    update_user_meta($current_user_id, 'user_credits_used', 0);
}
add_action('user_register', 'initialize_user_counter');

function increment_used_credits() {
    $current_user_id = get_current_user_id();
    $current_value = get_user_meta($current_user_id, 'user_credits_used', true);
    $new_value = $current_value + 1;
    $result = update_user_meta($current_user_id, 'user_credits_used', $new_value);
    return $result;
}

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

// Gets data from prompt table
function searchForPrompt($promptToSearch) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'gig_prompts';
    $query = "SELECT prompt_id
              FROM $table_name
              WHERE prompt = '$promptToSearch'";

    // result will be an empty array if no matches
    $result = $wpdb->get_results($query, ARRAY_A);

    $return = array(
        'Found' => !empty($result) ? 'Success' : 'Failure', //if the result is empty, then use the custom prompt, otherwise use the matching selected prompt id
        'Found_Prompt_ID' => !empty($result) ? $result[0] : null
    );
    
    wp_send_json($return);
}

// CV Table ------------------------------------------------------

// Gets data from wp_gf_entry that has a created_by value matching logged in user_id AND
// Return: array contains all entry_id's that belong to logged in user
function get_user_cv_form_entries() {

    $current_user_id = get_current_user_id();
    // $current_user_id = 5;

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
    }
    else {
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

// Gets data from user_history table for logged in user
function get_user_history_table_data() {

    $current_user_id = get_current_user_id();

    global $wpdb;
    $history_table = $wpdb->prefix . 'gig_user_history';
    $prompt_table = $wpdb->prefix . 'gig_prompts';
    $query = "SELECT h.`prompt_id`, p.`prompt_id`, p.`prompt_type`, p.`prompt`, h.`custom_prompt`, h.`cv_inputs`, h.`generated_response`, h.`created`
              FROM $history_table AS h
              LEFT JOIN $prompt_table AS p ON h.`prompt_id` = p.`prompt_id`
              WHERE h.`user_id` = '$current_user_id'";
    return $wpdb->get_results($query, ARRAY_A);
}

// Stores generation results in gig_user_history table
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

    $function_result = increment_used_credits();
   
    $return = array(
        'Execution' => $result ? 'Success' : 'Failure',
        'Credits Incremented' => $function_result ? 'Success' : 'Failure'
    );
    
    wp_send_json($return);
}

?>
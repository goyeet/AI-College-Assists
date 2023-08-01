<?php
/*
* Plugin Name: Table Custom Plugin
* Plugin URI: https://dev-ai-college-assists.pantheonsite.io/
* Description: Contains calls to create custom table in database and display them
* Version: 0.1
* Author: Gordon and Clarissa
* Author URI: https://dev-ai-college-assists.pantheonsite.io/
**/

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

function enqueue_custom_scripts() {
    wp_enqueue_script('gig-custom-script', str_replace("code/", "", plugin_dir_path(__FILE__)) . '/js/custom-script.js', array('jquery'), '1.0', true);
    wp_localize_script('gig-custom-script', 'my_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Shortcode that formats data into 3 column table
function prompt_table_shortcode() {

    $gig_user_id = get_option('gig_user_id');
    $gig_user_key = get_option('gig_user_key');
    // print_r("User ID: " . $gig_user_id . ", User Key: " . $gig_user_key);

    $table_data = get_prompt_table_data();
    if (empty($table_data)) {
        return '<p>No data available.</p>';
    }

    $output = '<table id="prompt-table">';
    $output .= '<tr><th>Prompt ID</th><th>Prompt Type</th><th>Prompt</th></tr>';

    foreach ($table_data as $row) {
        $output .= '<tr>';
        $output .= '<td class="prompt-id">' . esc_html($row['prompt_id']) . '</td>';
        $output .= '<td class="prompt-type">' . esc_html($row['prompt_type']) . '</td>';
        $output .= '<td class="prompt"><span>' . esc_html($row['prompt']) . '</span><div class="generated-response"> </div></td>';
        
		// Add button
        $output .= '<td>' . '<button class="generate-button">Generate</button>' . '</td>';
        $output .= '</tr>';
    }

    $output .= '</table>';
	// Prints Output
	print_r($output);
}
add_shortcode('prompt_table', 'prompt_table_shortcode');


////////////////////////////////////////

// global $wpdb;
// $table_name = $wpdb->prefix . 'prompts_table';

// $sql = "CREATE TABLE $prompts_table (
//     id INT NOT NULL AUTO_INCREMENT, 
//     column1 VARCHAR(15), 
//     column2 VARCHAR(400),
//     PRIMARY KEY (id)
// )"; //column1 is application type, column2 is the application prompt

// if ($sql !== NULL) {
//     echo "Not NULL";
// }

// $hostname = '35.225.163.97';
// $database_name = 'pantheon';
// $username = 'pantheon';
// $password = 'pOhItKUvlO9mzqR6YnWhYGRMXTAu9UCJ';

// $conn = new mysqli($hostname, $username, $password, $database_name);

// if ($conn->query($sql) === TRUE) {
//     echo "Table created successfully";
// } else {
//     echo "Error creating table: " . $conn->error;
// }

// $sql = "INSERT INTO prompts (prompt_type, prompt) VALUES
//     ('UC', 'Describe an example of your leadership experience in which you have positively influenced others, helped resolve disputes or contributed to group efforts over time.'),
//     ('UC', 'Every person has a creative side, and it can be expressed in many ways: problem solving, original and innovative thinking, and artistically, to name a few. Describe how you express your creative side. '),
//     ('UC', 'What would you say is your greatest talent or skill? How have you developed and demonstrated that talent over time?  '),
//     ('UC', 'Describe how you have taken advantage of a significant educational opportunity or worked to overcome an educational barrier you have faced.'),
//     ('UC', 'Describe the most significant challenge you have faced and the steps you have taken to overcome this challenge. How has this challenge affected your academic achievement?'),
//     ('UC', 'Think about an academic subject that inspires you. Describe how you have furthered this interest inside and/or outside of the classroom. '),
//     ('UC', 'What have you done to make your school or your community a better place?  '),
//     ('UC', 'Beyond what has already been shared in your application, what do you believe makes you a strong candidate for admissions to the University of California?'),
//     ('Common App', 'Some students have a background, identity, interest, or talent that is so meaningful they believe their application would be incomplete without it. If this sounds like you, then please share your story.'),
//     ('Common App', 'The lessons we take from obstacles we encounter can be fundamental to later success. Recount a time when you faced a challenge, setback, or failure. How did it affect you, and what did you learn from the experience?'),
//     ('Common App', 'Reflect on a time when you questioned or challenged a belief or idea. What prompted your thinking? What was the outcome?'),
//     ('Common App', 'Reflect on something that someone has done for you that has made you happy or thankful in a surprising way. How has this gratitude affected or motivated you?'),
//     ('Common App', 'Discuss an accomplishment, event, or realization that sparked a period of personal growth and a new understanding of yourself or others.'),
//     ('Common App', 'Describe a topic, idea, or concept you find so engaging that it makes you lose all track of time. Why does it captivate you? What or who do you turn to when you want to learn more?'),
//     ('Common App', 'Describe a topic, idea, or concept you find so engaging that it makes you lose all track of time. Why does it captivate you? What or who do you turn to when you want to learn more?'),
//     ('Coalition', 'Tell a story from your life, describing an experience that either demonstrates your character or helped to shape it.'),
//     ('Coalition', 'What interests or excites you? How does it shape who you are now or who you might become in the future?'),
//     ('Coalition', 'Describe a time when you had a positive impact on others. What were the challenges? What were the rewards?'),
//     ('Coalition', 'Has there been a time when an idea or belief of yours was questioned? How did you respond? What did you learn?'),
//     ('Coalition', 'What success have you achieved or obstacle have you faced? What advice would you give a sibling or friend going through a similar experience?'),
//     ('Coalition', 'Submit an essay on a topic of your choice.'),
//     ";

// if ($conn->query($sql) === TRUE) {
//     echo "Data inserted successfully";
// } else {
//     echo "Error inserting data: " . $conn->error;
// }

// $conn->close();

?>
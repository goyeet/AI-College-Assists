<?php
/**
* Plugin Name: GIG Essay Writer Plugin
* Plugin URI: https://dev-ai-college-assists.pantheonsite.io/
* Description: Creates plugin settings menu in WP Dashboard and contains API Calls
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

// Get User Credits
function gig_get_user_credits() {
    $gig_user_key = get_option('gig_user_key');
    $gig_user_id = get_option('gig_user_id');
    // Arguments to pass with GET request
    $args = array(
        'headers' => array(
            'Accept'  => 'application/json',
        )
    );

    try {
        $response = wp_remote_get("https://haily.aiexosphere.com/get_user_credits/?wp_user_id={$gig_user_id}&wp_user_key={$gig_user_key}", $args );
        // if GET request is successful
        if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
            $responseBody = json_decode($response['body']);
            // if JSON decode is successful
            if( json_last_error() === JSON_ERROR_NONE ) {
                echo '<pre>';
                print_r($responseBody);
                echo '</pre>';
            }
        }
    } catch( Exception $ex ) {
        //Handle Exception.
        print_r($ex);
    }
}

// Generate Essay
function gig_generate_essay($prompt) {
    // Arguments to pass with GET request
    $args = array(
        'body' => array(
            'wp_user_id'  => get_option('gig_user_id'),
            'wp_user_key' => get_option('gig_user_key'),
            'skill_name'  => 'GIGCollegeEssaySkill',
            'cue'         => $prompt,
        ),
        'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
    );

    try {
        $response = wp_remote_post('https://haily.aiexosphere.com/run_skill/', $args );
        // if POST request is successful
        if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
            // $responseBody = json_decode($response['body']);
            wp_send_json(json_decode($response['body']));
            /* // if JSON decode is successful
            if( json_last_error() === JSON_ERROR_NONE ) {
                echo '<pre>';
                print_r($responseBody);
                echo '</pre>';
            } */
        }
    } catch( Exception $ex ) {
        // Handle Exception.
        print_r($ex);
    }
}

function generateEssayAjax() {
    $prompt = $_POST['prompt'];
    /* TODO: Make sure to validate and sanitize those values. */

    gig_generate_essay($prompt);
}
add_action('wp_ajax_nopriv_generateEssayAjax', 'generateEssayAjax'); // for non-logged in user
add_action('wp_ajax_generateEssayAjax', 'generateEssayAjax');

// Generate Prompt
function gig_generate_prompt($gig_user_id, $gig_user_key) {
    // Arguments to pass with GET request
    $args = array(
        'body' => array(
            'wp_user_id'  => $gig_user_id,
            'wp_user_key' => $gig_user_key,
            'skill_name'  => 'GIGCollegeEssayPromptGenerator',
            'cue'         => 'The first time that I attended a water ballet performance, I experienced a synesthesia of sorts as I watched the swan-like movements of the swimmers unfold with the cadence and magic of lyrical poetry, the precisely executed sequences melding with the musical accompaniment to create an ethereal beauty that I had never imagined possible. “You belong out there, creating that elegance with them,” I heard the quiet but powerful voice of my intuition tell me. For the next six years, I heeded its advice, training rigorously to master the athletic and artistic underpinnings of synchronized swimming.  
I flailed and plunged with all the grace of an elephant seal during my first few weeks of training. I was quickly and thoroughly disabused of the notion that the poise and control that I so coveted would be easy to obtain. During the first phase of my training, I spent as much time out of the water as in it, occupying myself with Pilates, weight training, and gymnastics in order to build my strength and flexibility. I learned things about the sport that outsiders seldom realize: that performers aren’t allowed to touch the bottom of the pool, relying on an “eggbeater” technique also used by water polo players to stay afloat; that collisions and concussions are all too common; that sometimes the routine demands staying underwater for so long that the lungs burn and the vision becomes hazy. My initial intervals in the water were marked by a floundering feeling that seemed diametrically opposed to the grace that I sought. I began to question whether I was really cut out for the sport.  
I persisted through all of this and slowly but certainly I saw myself progress. My back tucks became tight and fluid, my oyster maneuvers controlled and rhythmical, my water wheels feeling so natural that I could have executed them in my sleep. Moreover, I became comfortable enough with my own role in the water that I was able to expand my awareness to the other members of my team, moving not just synchronistically, but also synergistically. During one of my first major performances, our routine culminated as I launched myself out of the water in a powerful boost, surging upward on the swelling currents of the symphonic accompaniment. I owned the elegant arc that I cut through air and water, my teammates and I executing the leap with the majestic effortlessness of a pod of dolphins frolicking in the sea. I reveled in the thunderous applause at the conclusion of our routine, for it meant that I had helped to create the kind of exquisite beauty that I had so admired years before.  
Though I never would have guessed this at the outset of my training, synchronized swimming has provided one of the central metaphors of my life. The first and most fundamental lesson that I learned was persistence, which I absorbed humbly and viscerally by way of aching muscles and chlorine-stung eyes. More subtly and powerfully, the sport also lent me an instinctive appreciation of the way that many parts interact to form an emergent whole, an understanding which I have applied to every area of my studies, from mechanical systems to biological networks to artistic design. I have become cognizant of the fact that, as when I am in the water, my own perception of myself is narrow and incomplete, that to really understand my role in life I need to see myself in terms of my interactions with those around me. Six years after my training began, I still pursue the sense of harmony and unity that synchronized swimming has instilled in me, riding the soft swells of destiny forward as I move on to the next phase of my life. ',
        ),
        'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
    );

    try {
        $response = wp_remote_post('https://haily.aiexosphere.com/run_skill/', $args );
        // if POST request is successful
        if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
            $responseBody = json_decode($response['body']);
            // if JSON decode is successful
            if( json_last_error() === JSON_ERROR_NONE ) {
                echo '<pre>';
                print_r($responseBody);
                echo '</pre>';
            }
        }
    } catch( Exception $ex ) {
        // Handle Exception.
        print_r($ex);
    }
}
add_action('generate_prompt', 'gig_generate_prompt', 10, 2);

// Get Skills API
function gig_get_skills_api($gig_user_id, $gig_user_key) {
    // Arguments to pass with GET request
    $args = array(
        'headers' => array(
            'Accept'  => 'application/json',
        )
    );

    try {
        $response = wp_remote_get("https://haily.aiexosphere.com/get_skills_api/?wp_user_id={$gig_user_id}&wp_user_key={$gig_user_key}&user_skills_only=0", $args );
        // if GET request is successful
        if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
            $responseBody = json_decode($response['body']);
            // if JSON decode is successful
            if( json_last_error() === JSON_ERROR_NONE ) {
                echo '<pre>';
                print_r($responseBody);
                echo '</pre>';
            }
        }
    } catch( Exception $ex ) {
        // Handle Exception.
        print_r($ex);
    }
}
add_action('get_skills_api', 'gig_get_skills_api', 10, 2);
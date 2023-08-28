<?php
// API calls ------------------------------------------------------------------

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
            wp_send_json(json_decode($response['body']));
        }
    } catch( Exception $ex ) {
        //Handle Exception.
        print_r($ex);
    }
}

// Generate Essay
function gig_generate_essay($cue) {
    // Arguments to pass with POST request
    $args = array(
        'body' => array(
            'wp_user_id'  => get_option('gig_user_id'),
            'wp_user_key' => get_option('gig_user_key'),
            'skill_name'  => 'GIGCollegeEssaySkill',
            'cue'         => $cue,
        ),
        'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
    );

    try {
        $response = wp_remote_post('https://haily.aiexosphere.com/run_skill/', $args );
        // if POST request is successful
        if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
            wp_send_json(json_decode($response['body']));
            // call the function
            incrementAPICallCounter();

        }
    } catch( Exception $ex ) {
        // Handle Exception.
        print_r($ex);
    }
}

// Generate Prompt
function gig_generate_prompt($cue) {
    // Arguments to pass with GET request
    $args = array(
        'body' => array(
            'wp_user_id'  => get_option('gig_user_id'),
            'wp_user_key' => get_option('gig_user_key'),
            'skill_name'  => 'GIGCollegeEssayPromptGenerator',
            'cue'         => $cue,
        ),
        'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
    );

    try {
        $response = wp_remote_post('https://haily.aiexosphere.com/run_skill/', $args );
        // if POST request is successful
        if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
            wp_send_json(json_decode($response['body']));
        }
    } catch( Exception $ex ) {
        // Handle Exception.
        print_r($ex);
    }
}

// Get Skills API
function gig_get_skills_api() {
    $gig_user_key = get_option('gig_user_key');
    $gig_user_id = get_option('gig_user_id');

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
            wp_send_json(json_decode($response['body']));
        }
    } catch( Exception $ex ) {
        // Handle Exception.
        print_r($ex);
    }
}
?>
<?php
/**
* Plugin Name: test-plugin
* Plugin URI: https://dev-ai-college-assists.pantheonsite.io/
* Description: Test.
* Version: 0.1
* Author: Gordon and Clarissa
* Author URI: https://dev-ai-college-assists.pantheonsite.io/
**/

$wp_user_id = 309;
$wp_user_key = ''; // deleted key for security

$args = array($wp_user_id, $wp_user_key);

$request = wp_remote_get( 'https://haily.aiexosphere.com/get_user_credits/' , $args);

if ( is_wp_error( $request ) ) {
	return false;
}

// print_r($request);

$body = 'test ' . wp_remote_retrieve_body( $request );

// print_r($body);

$data = json_decode( $body );

// print_r($data);


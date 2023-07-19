<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

// get saved user key and user id from database
$gig_user_key = get_option('gig_user_key');
$gig_user_id = get_option('gig_user_id');

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

            <h1>
                get_user_credits
            </h1>
            <?php
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
            ?>
            
            <h1>
                Run Skill
            </h1>
            <?php
                // Arguments to pass with GET request
                $args = array(
                    'body' => array(
                        'wp_user_id'  => $gig_user_id,
                        'wp_user_key' => $gig_user_key,
                        'skill_name'  => 'GIGCollegeEssaySkill',
                        'cue'         => 'Why You Should Use AI For Your Business',
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
                    //Handle Exception.
                    print_r($ex);
                }
            ?>
            
            <h1>
                get_skills_api
            </h1>
            <?php
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
                    //Handle Exception.
                    print_r($ex);
                }
            ?>


            <h1>
                GIGCollegeEssayPromptGenerator
            </h1>
           
            <?php
                // Arguments to pass with GET request
                $args = array(
                    'body' => array(
                        'wp_user_id'  => $gig_user_id,
                        'wp_user_key' => $gig_user_key,
                        'essay prompt'  => 'Describe an example of your leadership experience in which you have positively influenced others, helped resolve disputes or contributed to group efforts over time.',
                    ),
                );

                try {
                    $response = wp_remote_post('https://haily.aiexosphere.com/GIGCollegeEssayPromptGenerator/', $args );
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
                    //Handle Exception.
                    print_r($ex);
                }
            ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

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
                Get User Credits
            </h1>
            <?php 
                // calling the get_user_credits action hook
                // do_action('get_user_credits', $gig_user_id, $gig_user_key);
            ?>
            
            <h1>
                Essay Generation
            </h1>
            <?php
                // do_action('generate_essay', $gig_user_id, $gig_user_key);
            ?>

            <h1>
                Prompt Generation
            </h1>
            <?php
                // do_action('generate_prompt', $gig_user_id, $gig_user_key);
            ?>
            
            <h1>
                Get Skills API
            </h1>
            <?php
                // do_action('get_skills_api', $gig_user_id, $gig_user_key);
            ?>
           
            <?php
                echo do_shortcode('[prompt_table]');
            ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

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

            <div id="loading-spinner" class="hidden">
                <div class="loader"></div>
            </div>

            <style>
            /* CSS to style the loading page */
                /* body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                } */

                /** Actual Spinner */
                .loader {
                    border: 8px solid #f3f3f3;
                    border-top: 8px solid #3498db;
                    border-radius: 50%;
                    width: 60px;
                    height: 60px;
                    animation: spin 2s linear infinite;
                }

                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                .hidden {
                    display: none;
                }
            </style>

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
           
            <?php
                echo do_shortcode('[prompt_table]');
            ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

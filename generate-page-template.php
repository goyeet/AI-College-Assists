<?php
/*
Template Name: Generate Page
*/

// Check if the user is logged in
if ( !is_user_logged_in() ) {
    wp_redirect( wp_login_url() ); // Redirect to the login page
    exit;
}

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
			echo do_shortcode('[prompt_table]');
			echo do_shortcode('[cv_table]');
			echo do_shortcode('[user_history_table]');
		?>
		
		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php
get_footer();
?>

/*Version: 0.1
* Author: Gordon and Clarissa
* Author URI: https://dev-ai-college-assists.pantheonsite.io/
*/

<h1> Hello world! </h1>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
  </head>

  <header class="site-header">
	<p class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>
	</p>
	<p class="site-description"><?php bloginfo( 'description' ); ?></p>
</header><!-- .site-header -->
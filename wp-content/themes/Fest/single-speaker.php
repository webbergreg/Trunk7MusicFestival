<?php

/**
 *
 * Single page
 *
 **/

global $tpl;

gk_load('header');
gk_load('before');

?>

<section id="gk-mainbody">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php gk_content_nav(); ?>
		
		<?php get_template_part( 'content', 'speaker' ); ?>
	<?php endwhile; // end of the loop. ?>
</section>

<?php

gk_load('after');
gk_load('footer');

// EOF
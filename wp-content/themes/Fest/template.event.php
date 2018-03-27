<?php

/*
Template Name: Event page
*/
 
global $tpl;

$fullwidth = true;

gk_load('header');
gk_load('before', null, array('sidebar' => false));

?>

<section id="gk-mainbody">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php gk_content_nav(); ?>
		
		<?php get_template_part( 'content', 'event' ); ?>
	
		<?php comments_template( '', true ); ?>
	<?php endwhile; ?>
</section>

<?php

gk_load('after', null, array('sidebar' => false));
gk_load('footer');

// EOF
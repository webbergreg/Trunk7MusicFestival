<?php

/**
 *
 * The template for displaying content in the single.php template
 *
 **/
 
global $tpl;
 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(is_page_template('template.event.php') ? ' page-event' : null); ?>>
	<header>
		<span>* * *</span>
		<h1>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', GKTPLNAME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<span>* * *</span>
	</header>

	<?php get_template_part( 'layouts/content.post.featured' ); ?>

	<section class="content">
		<?php the_content(); ?>
		
		<?php gk_post_fields(); ?>
		<?php gk_post_links(); ?>
	</section>

	<?php get_template_part( 'layouts/content.post.footer' ); ?>
</article>

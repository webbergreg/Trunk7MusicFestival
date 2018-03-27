<?php
/** 
 * 
 * The template for displaying posts in the Speaker Post Format on index and archive pages 
 * 
 **/ 
 
 global $tpl; 

?>

<?php if(is_single()) : ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('gk-speaker gk-speaker-single'); ?>>
	<header>
		<?php if(has_post_thumbnail()) : ?>
		<figure class="featured-image">
			<?php the_post_thumbnail(); ?>
		</figure>
		<?php endif; ?>
		
		<?php if(get_the_title() != '') : ?>
		<h1>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', GKTPLNAME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; ?>
		
		<?php gk_post_fields(); ?>
	</header>
	
	<?php if(is_search() || is_archive() || is_tag()) : ?>
	<section class="summary">
		<?php the_excerpt(); ?>
	</section>
	<?php else : ?>
	<section class="content">
		<?php the_content(); ?>
		<?php gk_post_links(); ?>
	</section>
	<?php endif; ?>
	

	<?php 
		// variable for the social API HTML output
		$social_api_output = gk_social_api(get_the_title(), get_the_ID()); 
	?>
	
	<?php if(
		$social_api_output != '' || 
		(
			get_the_author_meta( 'description' ) && 
			get_option($tpl->name . '_template_show_author_info') == 'Y'
		)
	): ?>
	<footer>		
		<?php echo $social_api_output; ?>
	</footer>
	<?php endif; ?>
</article>
<?php else : ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('gk-speaker'); ?>>
	<?php if(has_post_thumbnail()) : ?>
	<figure class="featured-image">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', GKTPLNAME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<?php the_post_thumbnail(); ?>
		</a>
	</figure>
	<?php endif; ?>
	
	<?php if(get_the_title() != '') : ?>
	<h2>
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', GKTPLNAME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2>
	<?php endif; ?>
</article>
<?php endif; ?>
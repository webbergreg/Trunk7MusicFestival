<?php

/**
 *
 * Category page
 *
 **/

global $tpl;

$fullwidth = true;
$tmp = get_option('speakers_options');
$args = array( 'post_type' => $tmp['name'], 'posts_per_page' => 100 );
$loop = new WP_Query( $args );

if ($tmp['category_full'] == 'Disabled') : $fullwidth = false; endif;

gk_load('header');

if ($tmp['category_full'] == 'Enabled') {
     gk_load('before', null, array('sidebar' => false));
}

else {
     $fullwidth = false;
     gk_load('before');
}

?>

<section id="gk-mainbody" class="speakers-page">
	<header>
		<span>* * *</span>
		<h1 class="page-title">
			<?php echo single_cat_title( '', false ); ?>
		</h1>
		<span>* * *</span>
	</header>
	
	<div class="speakers-page-desc">
	<?php
		$category_description = category_description();
		if ( ! empty( $category_description ) )
			echo apply_filters( 'category_archive_meta', $category_description );
	?>
	</div>
	
	<?php if ( $loop->have_posts() ) : ?>
		<?php do_action('gavernwp_before_loop'); ?>
		
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php get_template_part( 'content', 'speaker' ); ?>
		<?php endwhile; ?>
		
		<?php do_action('gavernwp_after_loop'); ?>
		
	<?php else : ?>
		<h2 class="page-title">
			<?php _e( 'Nothing Found', GKTPLNAME ); ?>
		</h2>
	
		<section class="intro">
			<?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', GKTPLNAME ); ?>
		</section>
		
		<?php get_search_form(); ?>
	<?php endif; ?>
</section>

<?php

// we have to reset the post data
wp_reset_postdata();

if ($tmp['category_full'] == 'Enabled') {
     gk_load('after', null, array('sidebar' => false));
}
else  {
     $fullwidth = false;
     gk_load('after');
}
gk_load('footer');

// EOF